<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require APPPATH . '/libraries/RestController.php';

class ContactDirectory extends RestController
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: text/html; charset=UTF-8");
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    }
    /**
     * Returns all the contacts
     */
    public function contact_get()
    {
        $lastId = $this->uri->total_segments();
        $contactId = $this->uri->segment($lastId);

        $this->load->model('Contact');
        $res = null;

        if (is_numeric($contactId)) { // Returns a single contact object
            $contactObj = $this->Contact->retreiveContact($contactId);
            $res = $contactObj[0];
        } else {
            $paramName = $this->input->get('name');
            $paramTag = $this->input->get('tags');
            if ($paramName || $paramTag) {
                $res = $this->Contact->searchContactCriteria($paramName, $paramTag);
            } else {
                $res = $this->Contact->retrieveContactList();
            }
        }

        if ($res) {
            $this->response($res, RestController::HTTP_OK);
        } else {
            $this->response([
                'message' => 'No contacts found'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Inserts a new contact record
     */
    public function contact_post()
    {
        $contactData = $this->input->raw_input_stream;

        $this->load->model('Contact');
        $res = $this->Contact->createNewContact($contactData);
        if ($res) {
            $this->response($res, RestController::HTTP_CREATED);
        } else {
            $this->response([
                'message' => 'Failed to create contact'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Updates an existing contact record
     */
    public function contact_put()
    {
        $lastId = $this->uri->total_segments();
        $contactId = $this->uri->segment($lastId);

        $contactData = $this->input->raw_input_stream;

        $this->load->model('Contact');
        $res = $this->Contact->updateContact($contactId, $contactData);
        if ($res) {
            $this->response($res, RestController::HTTP_OK);
        } else {
            $this->response([
                'message' => 'Failed to create contact'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Deletes an existing contact record
     */
    public function contact_delete()
    {
        $lastId = $this->uri->total_segments();
        $contactId = $this->uri->segment($lastId);

        $this->load->model('Contact');
        $res = $this->Contact->deleteContact($contactId);

        if ($res) {
            $this->response($res, RestController::HTTP_OK);
        } else {
            $this->response([
                'message' => 'Failed to create contact'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
