App.state 'addProducts',
			url : '/add-products'
			parent : 'xooma'
			resolve : (stateName, params)->
				userModel : App.currentUser

