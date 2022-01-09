var app = app || {};

/**
 * Backbone models
 */

app.Models.Contact = Backbone.Model.extend({
	urlRoot: base_url + "/api/ContactDirectory/contact",
	defaults: {
		firstName: "",
		lastName: "",
		telephone: "",
		email: "",
		userTagsList: [],
	},
	idAttribute: "contactId",
});
