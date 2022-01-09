var app = app || {};
/**
 * Backbone collections
 */

contacts = Backbone.Collection.extend({
	url: base_url + "/api/ContactDirectory/contact",
	model: app.Models.Contact,
});

app.Collections.Contacts = new contacts();
