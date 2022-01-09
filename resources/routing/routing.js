var app = app || {};
/**
 * Routing
 */
var RouterModule = Backbone.Router.extend({
	routes: {
		"edit/:id": "updateContact",
		"delete/:id": "deleteContact",
	},
	updateContact: function (id) {
		app.Views.AddView.render({
			id: id,
		});
	},
	deleteContact: function (id) {
		app.Views.ContactListViewArea.deleteContact({
			id: id,
		});
	},
});

$(document).ready(function () {
	var routerMod = new RouterModule();
	Backbone.history.start({
		silent: true,
	});
});
