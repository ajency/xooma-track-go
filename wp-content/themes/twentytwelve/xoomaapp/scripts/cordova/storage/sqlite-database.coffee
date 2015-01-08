class SQLiteDatabaseController extends Marionette.Controller

	initialize : ->

		@db = window.sqlitePlugin.openDatabase
			name: "xooma.db"

		@createTable()


	createTable : ->

		@db.transaction (tx)->
			tx.executeSql "CREATE TABLE IF NOT EXISTS product_notifications (id UNIQUE, productID INTEGER, time, type)"
		, (error)->
			console.log 'SQLite Error: '+error.code
		, ->
			console.log 'Created Product Notifications Table'





# REQUEST HANDLER
App.reqres.setHandler "get:sqlite:database:controller", ->
	new SQLiteDatabaseController