<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<html>

<head>
    <title>My Contacts</title>

    <link rel="stylesheet" href="<?php echo base_url() ?>resources/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/main.css">

    <!-- Jquery -->
    <script src="<?php echo base_url() ?>resources/jquery-1.11.3.min.js"></script>
    <!-- Backbone -->
    <script src="<?php echo base_url() ?>resources/underscore-min.js"></script>
    <script src="<?php echo base_url() ?>resources/backbone-min.js"></script>

    <!-- Font-awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
    </script>

    <!-- Multiselect -->
    <script src="<?php echo base_url() ?>resources/bootstrap-multiselect.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>resources/bootstrap-multiselect.css" />

    <!-- Toastr popups -->
    <link href="<?php echo base_url() ?>resources/toastr.css" rel="stylesheet" />
    <script src="<?php echo base_url() ?>resources/toastr.js"></script>

</head>

<body style="background-color: #191964;">
    <!-- Header area -->
    <div class="header">
        <div class="container" style="margin: 20px">
            <div class="row">
                <div class="col" style="padding-left: 35px;">
                    <div class="row">
                        <img src="<?php echo base_url() ?>resources/img/contact-book.png" height="60px">
                        <h3>My Contact Directory</h3>
                    </div>
                </div>
                <!-- Search area -->
                <div class="col-8" style="padding-top: 15px;" id="searchArea">
                    <form class="form-inline" id="searchForm">
                        <div class="form-group mx-sm-3 mb-2" style="position: relative">
                            <input type="text" class="form-control" id="searchContactName" placeholder="Search contact">
                        </div>
                        <label for="searchTag">Tags</label>
                        <div class="form-group mx-sm-2 mb-2">
                            <select id="searchTag" multiple="multiple" class="dropdown-toggle">
                                <?php foreach ($tagList as $tagItem) { ?>
                                    <option value="<?= $tagItem ?>">
                                        <?= $tagItem ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="button" id="searchContactBtn" class="btn btn-primary mb-2">Search</button>
                        &nbsp
                        <button type="button" id="viewAllContactsBtn" class="btn btn-primary mb-2">View All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content area -->
    <div class="container" style="margin: 30px">
        <div class="row">
            <!-- Contact form area -->
            <div class="col">
                <div class="column side" id="inputarea">
                    <h4 id="formMethod">contact</h4>
                    <form id="addContactForm">
                        <input type="hidden" id="contactId">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control" id="telephone" placeholder="Telephone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="addTags">Tags</label>
                            <select id="addTags" multiple="multiple" class="dropdown-toggle">
                                <?php foreach ($tagList as $tagItem) { ?>
                                    <option value="<?= $tagItem ?>">
                                        <?= $tagItem ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- Save -->
                        <button type="button" id="addContactBtn" class="btn btn-primary">Save</button>

                        <!-- Update -->
                        <button type="button" id="updateContactBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="backBtn" class="btn btn-primary">Back</button>
                    </form>
                </div>
            </div>
            <!-- Contacts table view -->
            <div class="col-8">
                <div class="column middle">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tag(s)</th>
                            </tr>
                        </thead>
                        <tbody id="contactListArea">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url() ?>resources/js/main.js"></script>
    <!-- Models -->
    <script src="<?php echo base_url() ?>resources/js/models/contactModel.js"></script>
    <!-- Collections -->
    <script src="<?php echo base_url() ?>resources/js/collections/contactsCollection.js"></script>
    <!-- Views -->
    <script src="<?php echo base_url() ?>resources/js/views/contactAddEditViewArea.js"></script>
    <script src="<?php echo base_url() ?>resources/js/views/searchContactAreaView.js"></script>
    <script src="<?php echo base_url() ?>resources/js/views/contactListAreaView.js"></script>
    <!-- Routing -->
    <script src="<?php echo base_url() ?>resources/routing/routing.js"></script>

</body>

</html>