var app = app || {};
/**
 * Add/Edit contact operations
 */
var contactAddView = Backbone.View.extend({
	el: "#inputarea",
	initialize: function () {
		this.render();
	},
	events: {
		"click #addContactBtn": "addContact",
		"click #updateContactBtn": "updateContact",
		"click #backBtn": "goBack",
	},
	render: function (params) {
		var self = this;
		if (params) {
			var contact = new app.Models.Contact({
				contactId: params.id,
			});
			contact.fetch({
				async: false,
				success: function (contact) {
					var obj = contact.attributes;
					editFormShow();
					$("#contactId").val(obj.contactId);
					$("#firstName").val(obj.firstName);
					$("#lastName").val(obj.lastName);
					$("#telephone").val(obj.telephone);
					$("#email").val(obj.email);

					$("#addTags").val("");
					var tagsArray = obj.userTagsList;
					if (tagsArray.length > 0) {
						tagsArray.forEach((element) => {
							$("#addTags")
								.find("option[value=" + element + "]")
								.prop("selected", true);
							$("#addTags").multiselect("refresh");
						});
					} else {
						$("#addTags").val("");
						$("#addTags").multiselect("refresh");
					}
					return false;
				},
			});
		} else {
			addFormShow();
			$("#contactId").val("");
			return false;
		}
	},
	addContact: function () {
		var fn = $("#firstName").val();
		var ln = $("#lastName").val();
		var tel = $("#telephone").val();
		var e = $("#email").val();
		var tags = $("#addTags").val(); //add toastr validation
		if (fn == "") {
			toastr.warning("First Name is required");
		} else if (ln == "") {
			toastr.warning("Last Name is required");
		} else if (tel == "") {
			toastr.warning("Telephone number is required");
		} else {
			var contact = new app.Models.Contact({
				firstName: fn,
				lastName: ln,
				telephone: tel,
				email: e,
				userTagsList: tags,
			});
			contact.save().then((res) => {
				app.Collections.Contacts.add(contact);
				toastr.success("Contact added successfully");
			});
			$("#addTags").val("");
			$("#addTags").multiselect("refresh");
			$("#addContactForm")[0].reset();
		}
	},
	updateContact: function () {
		var id = $("#contactId").val();
		var fn = $("#firstName").val();
		var ln = $("#lastName").val();
		var tel = $("#telephone").val();
		var e = $("#email").val();
		var tags = $("#addTags").val();
		var contact = new app.Models.Contact({
			contactId: id,
			firstName: fn,
			lastName: ln,
			telephone: tel,
			email: e,
			userTagsList: tags,
		});
		contact.save().then((res) => {
			app.Collections.Contacts.reset(res);
		});
		$("#addContactForm")[0].reset();
		toastr.success("Contact updated successfully");
		addFormShow();
		Backbone.history.navigate("#", {
			trigger: true,
			replace: true,
		});
	},
	goBack: function () {
		$("#addContactForm")[0].reset();
		$("#addTags").val("");
		$("#addTags").multiselect("refresh");
		addFormShow();
		Backbone.history.navigate("#", {
			trigger: true,
			replace: true,
		});
	},
});

app.Views.AddView = new contactAddView();
