var app = app || {};
/**
 * Search contact operation
 */
var searchViewArea = Backbone.View.extend({
	model: app.Collections.Contacts,
	el: "#searchArea",
	events: {
		"click #searchContactBtn": "search",
		"click #viewAllContactsBtn": "viewAll",
	},
	search: function () {
		this.model.url = base_url + "/api/ContactDirectory/contact";
		var searchContactName = $("#searchContactName").val();
		var searchTagList = $("#searchTag").val();
		var searchTagString = searchTagList ? searchTagList.toString() : "";

		if (searchContactName == "" && searchTagString == "") {
			toastr.warning("Please fill search values");
		} else {
			this.model.url =
				this.model.url +
				"?name=" +
				searchContactName +
				"&tags=" +
				searchTagString;
			app.Collections.Contacts.fetch({
				wait: true,
				success: function (res) {
					app.Collections.Contacts.reset(res.models);
					toastr.info("Contacts fetched");
				},
				error: function () {
					app.Collections.Contacts.reset([]);
					toastr.info("No contacts found");
				},
			});
		}
	},
	viewAll: function () {
		this.model.url = base_url + "/api/ContactDirectory/contact";
		app.Collections.Contacts.fetch({
			wait: true,
			success: function (res) {
				app.Collections.Contacts.reset(res.models);
				toastr.info("Contacts fetched");
			},
			error: function () {
				app.Collections.Contacts.reset([]);
				toastr.info("No match found");
			},
		});
		$("#searchTag").val("");
		$("#searchTag").multiselect("refresh");
		$("#searchForm")[0].reset();
	},
});

var searchView = new searchViewArea();
