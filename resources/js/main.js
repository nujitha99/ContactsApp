var app = app || {};
app.Models = {};
app.Collections = {};
app.Views = {};

var base_url = "http://localhost:8080/w1742286/index.php";

$(document).ready(function () {
	$("#addTags").multiselect();
	$("#searchTag").multiselect();
});

toastr.options.closeDuration = 200;

/**
 * Events
 */
function addFormShow() {
	$("#formMethod").text("Add contact");
	$("#addContactBtn").show();
	$("#updateContactBtn").hide();
	$("#backBtn").hide();
}

function editFormShow() {
	$("#formMethod").text("Update contact");
	$("#addContactBtn").hide();
	$("#updateContactBtn").show();
	$("#backBtn").show();
}
