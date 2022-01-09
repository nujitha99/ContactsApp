var app = app || {};

/**
 * Contact list view area
 */
var listView = Backbone.View.extend({
	model: app.Collections.Contacts,
	el: $("#contactListArea"),
	initialize: function () {
		app.Collections.Contacts.fetch({
			async: false,
		});
		this.render();
		this.model.on("add", this.render, this);
		this.model.on("reset", this.render, this);
		this.model.on("remove", this.render, this);
	},
	render: function () {
		var self = this;
		var contacts = app.Collections.Contacts;
		if (this.$el.length > 0) {
			this.$el[0].innerHTML = "";
		}
		contacts.each(function (contact) {
			var tagsCell = "";
			var tagsCellList = contact.get("userTagsList");
			if (tagsCellList) {
				if (tagsCellList.length > 0) {
					for (let value of tagsCellList) {
						tagsCell +=
							"<span class='label label-warning'>" + value + "</span> &nbsp";
					}
				}
			}

			var contactRow =
				"<tr> <td>" +
				contact.get("firstName") +
				" " +
				contact.get("lastName") +
				"</td> <td>" +
				contact.get("telephone") +
				"</td> <td>" +
				contact.get("email") +
				"</td> <td>" +
				tagsCell +
				"</td> <td> <a href='" +
				base_url +
				"/Contacts/#/edit/" +
				contact.get("contactId") +
				"'> <i class='fas fa-edit'> </i> </a>" +
				"</td> <td> <a href='" +
				base_url +
				"/Contacts/#/delete/" +
				contact.get("contactId") +
				"'> <i class='fas fa-trash-alt'> </i> </a> </td> </tr>";
			self.$el.append(contactRow);
		});
	},
	deleteContact: function (params) {
		var contact = new app.Models.Contact({
			contactId: params.id,
		});
		contact.destroy().then((res) => {
			app.Collections.Contacts.remove(contact);
		});
		toastr.success("Contact deleted successfully");
		Backbone.history.navigate("#", {
			trigger: true,
			replace: true,
		});
	},
});

app.Views.ContactListViewArea = new listView();
