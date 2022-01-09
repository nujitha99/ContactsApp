<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Model
{
    public function searchContactCriteria($name, $tags)
    {
        if ($name && $tags) {
            $tagsArr = strpos($tags, ',') ? explode(',', $tags) : [$tags];
            // Select contacts matching to name
            $contactItem = $this->db->get_where('contacts', array('lastName' => $name));
            foreach ($contactItem->result() as $contact) {
                $contact->userTagsList = array();
                foreach ($this->getUserTagsList() as $item) {
                    if ($contact->contactId == $item->contactId) {
                        array_push($contact->userTagsList, $item->tagName);
                    }
                }
            }

            // Select contacts having matching tags
            $this->db->select('contactId');
            $this->db->from('userTags');
            $this->db->where_in('tagName', $tagsArr);
            $tagContactsIds = $this->db->get();
            $tagContactsIdsList = $tagContactsIds->result();

            // Remove contacts without matching tags
            $contactIdArr = array();
            foreach ($tagContactsIdsList as $item) {
                array_push($contactIdArr, $item->contactId);
            }
            $filteredContactList = array();
            foreach ($contactItem->result() as $contact) {
                if (in_array($contact->contactId, $contactIdArr)) {
                    array_push($filteredContactList, $contact);
                }
            }
            return $filteredContactList;
        }
        if ($tags) {
            $tagsArr = strpos($tags, ',') ? explode(',', $tags) : [$tags];

            $this->db->select('contactId');
            $this->db->from('userTags');
            $this->db->where_in('tagName', $tagsArr);
            $tagContactsIds = $this->db->get();
            $tagContactsIdsList = $tagContactsIds->result();

            $contactIdArr = array();
            foreach ($tagContactsIdsList as $item) {
                array_push($contactIdArr, $item->contactId);
            }

            $this->db->from('contacts');
            $this->db->where_in('contactId', $contactIdArr);
            $tagContactList = $this->db->get();
            foreach ($tagContactList->result() as $contact) {
                $contact->userTagsList = array();
                foreach ($this->getUserTagsList() as $item) {
                    if ($contact->contactId == $item->contactId) {
                        array_push($contact->userTagsList, $item->tagName);
                    }
                }
            }
            return $tagContactList->result();
        }
        if ($name) {
            $contactItem = $this->db->get_where('contacts', array('lastName' => $name));
            foreach ($contactItem->result() as $contact) {
                $contact->userTagsList = array();
                foreach ($this->getUserTagsList() as $item) {
                    if ($contact->contactId == $item->contactId) {
                        array_push($contact->userTagsList, $item->tagName);
                    }
                }
            }
            return $contactItem->result();
        }
    }

    public function retreiveContact($contactId)
    {
        $contactItem = $this->db->get_where('contacts', array('contactId' => $contactId));
        $contactTagList = $this->getTagsOfContact($contactId);
        foreach ($contactItem->result() as $contactItemRes) {
            $contactItemRes->userTagsList = array();
            if ($contactTagList) {
                foreach ($contactTagList as $tagItem) {
                    array_push($contactItemRes->userTagsList, $tagItem->tagName);
                }
            } else {
                $contactItemRes->userTagsList = [];
            }
        }

        return $contactItem->result();
    }

    public function retrieveContactList()
    {
        $res = $this->db->get('contacts');
        foreach ($res->result() as $contact) {
            $contact->userTagsList = array();
            foreach ($this->getUserTagsList() as $item) {
                if ($contact->contactId == $item->contactId) {
                    array_push($contact->userTagsList, $item->tagName);
                }
            }
        }
        return $res->result();
    }

    public function createNewContact($contactData)
    {
        $cleanedContactData = $this->sanitize_data($contactData);
        $contactObj = [
            'firstName' => $cleanedContactData['firstName'],
            'lastName' => $cleanedContactData['lastName'],
            'telephone' => $cleanedContactData['telephone'],
            'email' => $cleanedContactData['email'],
        ];
        $saveContactStatus = $this->db->insert('contacts', $contactObj);
        $contactId = $this->db->insert_id();
        $saveTagStatus = true;

        if (count($cleanedContactData['userTagsList']) > 0) {
            foreach ($cleanedContactData['userTagsList'] as $tagName) {
                $data = [
                    'contactId' => intval($contactId),
                    'tagName'  => $tagName
                ];
                $saveTagStatus = $this->db->insert('userTags', $data);
            }
        }

        $savedItem = $this->db->get_where('contacts', array('contactId' => $contactId));
        if ($saveContactStatus & $saveTagStatus) {
            return $savedItem->result()[0];
        } else {
            return null;
        }
    }

    public function updateContact($contactId, $contactData)
    {
        $cleanedContactData = $this->sanitize_data($contactData);
        $contactObj = [
            'firstName' => $cleanedContactData['firstName'],
            'lastName' => $cleanedContactData['lastName'],
            'telephone' => $cleanedContactData['telephone'],
            'email' => $cleanedContactData['email'],
        ];
        // Update contact details
        $this->db->where('contactId', $contactId);
        $updateStatus = $this->db->update('contacts', $contactObj);

        // Update tags details
        $this->db->where('contactId', $contactId);
        $this->db->delete('userTags');

        $tagUpdateStatus = true;
        if (count($cleanedContactData['userTagsList']) > 0) {
            foreach ($cleanedContactData['userTagsList'] as $tagName) {
                $data = [
                    'contactId' => intval($contactId),
                    'tagName'  => $tagName
                ];
                $tagUpdateStatus = $this->db->insert('userTags', $data);
            }
        }

        if ($updateStatus & $tagUpdateStatus) {
            $savedItems = $this->retrieveContactList();
            return $savedItems;
        } else {
            return null;
        }
    }

    public function deleteContact($contactId)
    {
        $this->db->where('contactId', $contactId);
        $deleteTagStatus = $this->db->delete('userTags');

        $this->db->where('contactId', $contactId);
        $deleteContactStatus = $this->db->delete('contacts');

        if ($deleteTagStatus & $deleteContactStatus) {
            return true;
        } else {
            return null;
        }
    }

    private function getTagsOfContact($contactId)
    {
        $tagData = array();
        $this->db->select('tagName');
        $this->db->where('contactId', $contactId);
        $res = $this->db->get('userTags');
        if ($res->num_rows() >= 1) {
            foreach ($res->result() as $tag) {
                array_push($tagData, $tag);
            }
            return $tagData;
        }
        return null;
    }

    public function getTagList()
    {
        $tagData = array();
        $res = $this->db->get('tags');
        if ($res->num_rows() >= 1) {
            foreach ($res->result() as $tag) {
                $tagData[$tag->tagName] = $tag->tagName;
            }
            return $tagData;
        }
        return null;
    }

    private function getUserTagsList()
    {
        $this->db->join('tags', 'tags.tagName = userTags.tagName');
        $res = $this->db->get('userTags');
        return $res->result();
    }

    private function sanitize_data($data)
    {
        $d = $this->security->xss_clean($data);
        $request = json_decode($d, true);
        return $request;
    }
}
