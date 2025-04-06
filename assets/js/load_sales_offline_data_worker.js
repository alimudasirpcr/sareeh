importScripts('pouchdb.min.js');
importScripts('pouchdb.find.js');

function decodeHtml(html) {
    return html.replace(/&lt;/g, "<")
               .replace(/&gt;/g, ">")
               .replace(/&amp;/g, "&")
               .replace(/&quot;/g, '"')
               .replace(/&#039;/g, "'");
}


try
{
	var customer_limit = 100;
	var item_limit = 1000;
	var category_limit = 100;
	var taxes_limit = 100;
	var one_day_in_minutes = 24*60;//init value 24 hours

	var ajax = function(url, data, callback, type) {
	  var data_array, data_string, idx, req, value;
	  if (data == null) {
	    data = {};
	  }
	  if (callback == null) {
	    callback = function() {};
	  }
	  if (type == null) {
	    //default to a GET request
	    type = 'GET';
	  }
	  data_array = [];
	  for (idx in data) {
	    value = data[idx];
	    data_array.push("" + idx + "=" + value);
	  }
	  data_string = data_array.join("&");
	  req = new XMLHttpRequest();
	  req.open(type, url, false);
	  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  req.onreadystatechange = function() {
	    if (req.readyState === 4 && req.status === 200) {
	      return callback(req.responseText);
	    }
	  };
	  req.send(data_string);
	  return req;
	};

	settings = {};


	//TODO need to check health (bad phppos_settings) NO tables
	var db_settings = new PouchDB('phppos_settings',{revs_limit: 1});
	var db_customers = new PouchDB('phppos_customers',{revs_limit: 1});
	var db_items = new PouchDB('phppos_items',{revs_limit: 1});
	var db_category = new PouchDB('phppos_category',{revs_limit: 1});
	var db_taxes = new PouchDB('phppos_taxes',{revs_limit: 1});
	
	
	function sendUpdateToClient(step) {
		self.clients.matchAll().then(clients => {
			clients.forEach(client => client.postMessage({ step }));
		});
	}
	self.addEventListener('install', (event) => {
		console.log('Service Worker installing...');
		self.skipWaiting();  // Forces activation
	});
	
	self.addEventListener('activate', (event) => {
		console.log('Service Worker activated!');
		event.waitUntil(self.clients.claim());  // Takes control of open pages
	});

	self.addEventListener("message",  function(e) 
	{

		
			console.log("connected");
			
		settings = e.data;
		console.log(settings);
		if(settings.offline_mode_sync_period)
		one_day_in_minutes = settings.offline_mode_sync_period * 60;

		if(settings.msg=='force'){
			loadCustomersOffline();
			loadCategoryOffline();
			loadItemsOffline();
			
		}

		
	
		db_settings.get('customers_sync_last_run_time',async function (error, doc) 
		{
			if (error) 
			{
				await db_settings.put({'_id':'customers_sync_last_run_time','value': 0 });
				loadCustomersOffline();
				
			} 
			else 
			{
				var last_run = doc.value;
				var time_since_last_run_in_minutes = Math.floor((Math.abs(Date.now() - last_run)/1000)/60);
			
				if (time_since_last_run_in_minutes >=one_day_in_minutes)
				{
					loadCustomersOffline();
				}
			}
		});	
		db_settings.get('category_sync_last_run_time',async function (error, doc) 
		{
			if (error) 
			{
				await db_settings.put({'_id':'category_sync_last_run_time','value': 0 });
				loadCategoryOffline();
			} 
			else 
			{
				var last_run = doc.value;
				var time_since_last_run_in_minutes = Math.floor((Math.abs(Date.now() - last_run)/1000)/60);
			
				if (time_since_last_run_in_minutes >=one_day_in_minutes)
				{
					loadCategoryOffline();
				}
			}
		});	

		db_settings.get('items_sync_last_run_time',async function (error, doc) 
		{
			
			if (error) 
			{
				await db_settings.put({'_id':'items_sync_last_run_time','value': 0 });
				loadItemsOffline();
			} 
			else 
			{
				var last_run = doc.value;
				var time_since_last_run_in_minutes = Math.floor((Math.abs(Date.now() - last_run)/1000)/60);
			
				if (time_since_last_run_in_minutes >=one_day_in_minutes)
				{
					loadItemsOffline();
				}
			}
		});	


		db_settings.get('taxes_sync_last_run_time',async function (error, doc) 
		{
			if (error) 
			{
				await db_settings.put({'_id':'taxes_sync_last_run_time','value': 0 });
				loadTaxesOffline();
			} 
			else 
			{
				var last_run = doc.value;
				var time_since_last_run_in_minutes = Math.floor((Math.abs(Date.now() - last_run)/1000)/60);
			
				if (time_since_last_run_in_minutes >=one_day_in_minutes)
				{
					loadTaxesOffline();
				}
			}
		});	
		
	
	}, false);
	// loadTaxesOffline();
	// loadItemsOffline();
	// loadCategoryOffline();
	// loadCustomersOffline();
	async function loadCustomersOffline(base_url)
	{

		console.log('loadCustomersOffline');
		try
		{
			await db_customers.createIndex({
			  index: {
			    fields: ['first_name']
			  }
			});

			await db_customers.createIndex({
			  index: {
			    fields: ['last_name']
			  }
			});
	
			await db_customers.createIndex({
			  index: {
			    fields: ['first_name', 'last_name']
			  }
			});
	
			await db_customers.createIndex({
			  index: {
			    fields: ['full_name']
			  }
			});
	
	
			await db_customers.createIndex({
			  index: {
			    fields: ['account_number']
			  }
			});
		}
		catch (err)
		{
			//If we cannot make indexes we are in a bad state and we need to start over
			postMessage('delete_all_client_side_dbs');
			throw new Error('Invalid state resetting databases');
		}
	
		try 
		{
			await db_customers.get('_design/search');
		}
		catch (err) //Need to make the doc
		{
		    var ddoc = {
		      _id: '_design/search',
		      views: {
		       search: {
		        map: function(doc) {
		        const regex = /[\s\.;]+/gi;
		        ['last_name','first_name','full_name','account_number'].forEach(field => {
		          if (doc[field]) {
				  
					  emit(doc[field].toLocaleLowerCase(), [field, doc[field]]);
				  
					  const words = doc[field].replaceAll(regex,
		              ',').split(',');
		            words.forEach(word => {
		              word = word.trim();
		              if (word.length) {
		                emit(word.toLocaleLowerCase(), [field, word]);
		              }
		            });
		          }
		        });
		       }.toString()
		      }
		      }
		    };
			try
			{
				await db_customers.put(ddoc);
			}
			catch(err2)
			{
				//If we cannot make indexes we are in a bad state and we need to start over
				postMessage('delete_all_client_side_dbs');
				throw new Error('Invalid state resetting databases');
			}
		}

	
		db_settings.get('offline_customer_offset',async function (error, doc) 
		{
			if (error) 
			{
				customer_offset = 0;
				try
				{
					await db_settings.put({'_id':'offline_customer_offset','value': customer_offset });
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/customers_offline_data/'+customer_limit+"/"+customer_offset;
				ajax(url, {}, processCustomerAjax, 'POST');
			
			} 
			else 
			{
				var new_offline_customer_offset = {'_id': 'offline_customer_offset','value': (parseInt(doc.value))};
				new_offline_customer_offset['_rev'] = doc._rev;
				try
				{
					await db_settings.put(new_offline_customer_offset,{force: true});
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/customers_offline_data/'+customer_limit+"/"+(parseInt(doc.value));
				ajax(url, {}, processCustomerAjax, 'POST');
			
			}
		});		

		async function deleteAllCustomers() {
			try {
				const allDocs = await db_customers.allDocs(); // Get all documents
		
				const deletePromises = allDocs.rows.map(row => {
					return db_customers.remove(row.id, row.value.rev); // Prepare to delete each document
				});
		
				await Promise.all(deletePromises); // Execute all delete operations
				console.log('All Customers deleted.');
			} catch (error) {
				console.error('Error deleting Customers:', error);
			}
		}
		async function processCustomerAjax(data) 
		{
			postMessage('1');
			
			var customers = JSON.parse(data);
			console.log('processCustomerAjax' , customers);
			// deleteAllCustomers();
			for(var k=0;k<customers.length;k++)
			{
				var customer = customers[k];

				
				var new_customer = {'_id': customer.person_id+'_customer',first_name: customer.first_name,last_name:customer.last_name,full_name:customer.first_name+' '+customer.last_name,account_number:customer.account_number,person_id:customer.person_id,phone_number:customer.phone_number,email:customer.email,balance:customer.balance,internal_notes:customer.internal_notes};
				
				
				try
				{
					var doc = await db_customers.get(customers[k].person_id+"_customer");
					new_customer['_rev'] = doc._rev;
					await db_customers.put(new_customer,{force: true});
				}
				catch(error)
				{
					await db_customers.put(new_customer);
				}	
			}
		
			await db_customers.query('search', {
			  reduce: true
			});
	
	
			db_settings.get('offline_customer_offset',async function (error, doc) 
			{
				//Keep going
				if (customers.length)
				{
					var new_offline_customer_offset = {'_id': 'offline_customer_offset','value': parseInt(doc.value)+customer_limit};
					new_offline_customer_offset['_rev'] = doc._rev;
					await db_settings.put(new_offline_customer_offset,{force: true});
				
					var url = settings.site_url+'/sales/customers_offline_data/'+customer_limit+"/"+(parseInt(doc.value)+customer_limit);
					ajax(url, {}, processCustomerAjax, 'POST');
				}
				else
				{
					var new_offline_customer_offset = {'_id': 'offline_customer_offset','value': 0};
					new_offline_customer_offset['_rev'] = doc._rev;
					await db_settings.put(new_offline_customer_offset,{force: true});
				
					db_settings.get('customers_sync_last_run_time',async function (error2, doc2) 
					{	
						//Put the Date in we just ran so it don't run for a bit
						var new_customers_sync_last_run_time = {'_id': 'customers_sync_last_run_time','value': Date.now()};
						new_customers_sync_last_run_time['_rev'] = doc2._rev;
						await db_settings.put(new_customers_sync_last_run_time,{force: true});
					});	
				}
			
			});	
		
	
		}


	}
	async function loadCategoryOffline(base_url)
	{

		console.log('loadCategoryOffline');
		try
		{
			await db_category.createIndex({
			  index: {
			    fields: ['name']
			  }
			});

		}
		catch (err)
		{
			//If we cannot make indexes we are in a bad state and we need to start over
			postMessage('delete_all_client_side_dbs');
			throw new Error('Invalid state resetting databases');
		}
	
		try 
		{
			await db_category.get('_design/search');
		}
		catch (err) //Need to make the doc
		{
		    var ddoc = {
		      _id: '_design/search',
		      views: {
		       search: {
		        map: function(doc) {
		        const regex = /[\s\.;]+/gi;
		        ['name'].forEach(field => {
		          if (doc[field]) {
				  
					  emit(doc[field].toLocaleLowerCase(), [field, doc[field]]);
				  
					  const words = doc[field].replaceAll(regex,
		              ',').split(',');
		            words.forEach(word => {
		              word = word.trim();
		              if (word.length) {
		                emit(word.toLocaleLowerCase(), [field, word]);
		              }
		            });
		          }
		        });
		       }.toString()
		      }
		      }
		    };
			try
			{
				await db_category.put(ddoc);
			}
			catch(err2)
			{
				//If we cannot make indexes we are in a bad state and we need to start over
				postMessage('delete_all_client_side_dbs');
				throw new Error('Invalid state resetting databases');
			}
		}

	
		db_settings.get('offline_category_offset',async function (error, doc) 
		{
			if (error) 
			{
				category_offset = 0;
				try
				{
					await db_settings.put({'_id':'offline_category_offset','value': category_offset });
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/categories_offline_data/'+category_limit+"/"+category_offset;
				ajax(url, {}, processCategoryAjax, 'POST');
			
			} 
			else 
			{
				var new_offline_category_offset = {'_id': 'offline_category_offset','value': (parseInt(doc.value))};
				new_offline_category_offset['_rev'] = doc._rev;
				try
				{
					await db_settings.put(new_offline_category_offset,{force: true});
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/categories_offline_data/'+category_limit+"/"+(parseInt(doc.value));
				ajax(url, {}, processCategoryAjax, 'POST');
			
			}
		});		
	}



	async function loadTaxesOffline(base_url)
	{
		
		console.log('loadTaxesOffline news');
		try
		{
			console.log('db_taxes');
			await db_taxes.createIndex({
			  index: {
			    fields: ['name']
			  }
			});
			
		}
		catch (err)
		{
			console.log('loadTaxesOffline err' , err);
			//If we cannot make indexes we are in a bad state and we need to start over
			postMessage('delete_all_client_side_dbs');
			throw new Error('Invalid state resetting databases');
		}
		console.log('loadTaxesOffline sts' );
		try 
		{
			await db_taxes.get('_design/search');
		}
		catch (err) //Need to make the doc
		{
		    var ddoc = {
		      _id: '_design/search',
		      views: {
		       search: {
		        map: function(doc) {
		        const regex = /[\s\.;]+/gi;
		        ['name'].forEach(field => {
		          if (doc[field]) {
				  
					  emit(doc[field].toLocaleLowerCase(), [field, doc[field]]);
				  
					  const words = doc[field].replaceAll(regex,
		              ',').split(',');
		            words.forEach(word => {
		              word = word.trim();
		              if (word.length) {
		                emit(word.toLocaleLowerCase(), [field, word]);
		              }
		            });
		          }
		        });
		       }.toString()
		      }
		      }
		    };
			try
			{
				await db_taxes.put(ddoc);
			}
			catch(err2)
			{
				//If we cannot make indexes we are in a bad state and we need to start over
				postMessage('delete_all_client_side_dbs');
				throw new Error('Invalid state resetting databases');
			}
		}

		console.log('loadTaxesOffline error' );
		db_settings.get('offline_taxes_offset',async function (error, doc) 
		{
			console.log('loadTaxesOffline error' , error);
			if (error) 
			{
				taxes_offset = 0;
				try
				{
					await db_settings.put({'_id':'offline_taxes_offset','value': taxes_offset });
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/taxes_offline_data/'+taxes_limit+"/"+taxes_offset;
				ajax(url, {}, processTaxesAjax, 'POST');
			
			} 
			else 
			{
				var new_offline_taxes_offset = {'_id': 'offline_taxes_offset','value': (parseInt(doc.value))};
				new_offline_taxes_offset['_rev'] = doc._rev;
				try
				{
					await db_settings.put(new_offline_taxes_offset,{force: true});
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/taxes_offline_data/'+taxes_limit+"/"+(parseInt(doc.value));
				ajax(url, {}, processTaxesAjax, 'POST');
			
			}
		});		
	}

	async function deleteAllCategories() {
		try {
			const allDocs = await db_category.allDocs(); // Get all documents
	
			const deletePromises = allDocs.rows.map(row => {
				return db_category.remove(row.id, row.value.rev); // Prepare to delete each document
			});
	
			await Promise.all(deletePromises); // Execute all delete operations
			console.log('All documents deleted.');
		} catch (error) {
			console.error('Error deleting documents:', error);
		}
	}

	async function processTaxesAjax(data) 
	{
		var taxes = JSON.parse(data);

		console.log('processTaxesAjax.' , taxes);
		// deleteAlltaxes();
		for(var k=0;k<taxes.length;k++)
		{
		
			var Taxes = taxes[k];
			var new_taxes = {'_id': Taxes.id+'_taxes',name: Taxes.name , id: Taxes.id , group : Taxes.group };
			
			try
			{
				var doc = await db_taxes.get(taxes[k].id+"_taxes");
				new_taxes['_rev'] = doc._rev;
				await db_taxes.put(new_taxes,{force: true});
			}
			catch(error)
			{
				await db_taxes.put(new_taxes);
			}	
		}
	
	    await db_taxes.query('search', {
	      reduce: true
	    });



	

	}
	async function processCategoryAjax(data) 
	{
		var categorys = JSON.parse(data);
		postMessage('2');
		console.log(categorys);
		// deleteAllCategories();
		for(var k=0;k<categorys.length;k++)
		{
			var category = categorys[k];
			var new_category = {'_id': category.id+'_category',name: category.name, img_src: category.img_src, sub_categories: category.sub_categories_count , items_count: category.items_count ,   sub_categories_list: category.sub_categories};
			try
			{
				var doc = await db_category.get(categorys[k].id+"_category");
				new_category['_rev'] = doc._rev;
				await db_category.put(new_category,{force: true});
			}
			catch(error)
			{
				await db_category.put(new_category);
			}	
		}
	
	    await db_category.query('search', {
	      reduce: true
	    });


		db_settings.get('offline_category_offset',async function (error, doc) 
		{
			//Keep going
			if (category.length)
			{
				var new_offline_category_offset = {'_id': 'offline_category_offset','value': parseInt(doc.value)+category_limit};
				new_offline_category_offset['_rev'] = doc._rev;
				await db_settings.put(new_offline_category_offset,{force: true});
			
				var url = settings.site_url+'/sales/categories_offline_data/'+category_limit+"/"+(parseInt(doc.value)+category_limit);
				ajax(url, {}, processcategoryAjax, 'POST');
			}
			else
			{
				var new_offline_category_offset = {'_id': 'offline_category_offset','value': 0};
				new_offline_category_offset['_rev'] = doc._rev;
				await db_settings.put(new_offline_category_offset,{force: true});
			
				db_settings.get('category_sync_last_run_time',async function (error2, doc2) 
				{	
					//Put the Date in we just ran so it don't run for a bit
					var new_category_sync_last_run_time = {'_id': 'category_sync_last_run_time','value': Date.now()};
					new_category_sync_last_run_time['_rev'] = doc2._rev;
					await db_settings.put(new_category_sync_last_run_time,{force: true});
				});	
			}
		
		});	
	

	}

	
	async function loadItemsOffline(base_url)
	{


		try
		{
			await db_items.createIndex({
			  index: {
			    fields: ['name']
			  }
			});

			await db_items.createIndex({
			  index: {
			    fields: ['item_number']
			  }
			});
	
			 await db_items.createIndex({
			  index: {
			    fields: ['product_id']
			  }
			});
		}
		catch(error)
		{
			//If we cannot make indexes we are in a bad state and we need to start over
			postMessage('delete_all_client_side_dbs');
			throw new Error('Invalid state resetting databases');
		}
	
		try 
		{
			await db_items.get('_design/search');
		}
		catch (err) //Need to make the doc
		{
		    var ddoc = {
		      _id: '_design/search',
		      views: {
		       search: {
		        map: function(doc) {
		        const regex = /[\s\.;]+/gi;
		        ['name','item_number','product_id'].forEach(field => {
		          if (doc[field]) {
				  
					emit(doc[field].toLocaleLowerCase(), [field, doc[field]]);
				  
		            const words = doc[field].replaceAll(regex,
		              ',').split(',');
		            words.forEach(word => {
		              word = word.trim();
		              if (word.length) {
		                emit(word.toLocaleLowerCase(), [field, word]);
		              }
		            });
		          }
		        });
		       }.toString()
		      }
		      }
		    };
			try
			{
				await db_items.put(ddoc);
			}
			catch(error2)
			{
				//If we cannot make indexes we are in a bad state and we need to start over
				postMessage('delete_all_client_side_dbs');
				throw new Error('Invalid state resetting databases');
			}
		}


		db_settings.get('offline_item_offset',async function (error, doc) 
		{
			if (error) 
			{
				item_offset = 0;
				try
				{
					await db_settings.put({'_id':'offline_item_offset','value': item_offset });
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/items_offline_data/'+item_limit+"/"+item_offset;
				ajax(url, {}, processItemAjax, 'POST');
			
			} 
			else 
			{
				var new_offline_item_offset = {'_id': 'offline_item_offset','value': (parseInt(doc.value))};
				new_offline_item_offset['_rev'] = doc._rev;
				try
				{
					await db_settings.put(new_offline_item_offset,{force: true});
				}
				catch(error2)
				{
					//If we cannot make indexes we are in a bad state and we need to start over
					postMessage('delete_all_client_side_dbs');
					throw new Error('Invalid state resetting databases');
				}
				var url = settings.site_url+'/sales/items_offline_data/'+item_limit+"/"+(parseInt(doc.value));
				ajax(url, {}, processItemAjax, 'POST');
			
			}
		});		
	
		async function deleteAllDocuments() {
			try {
				const allDocs = await db_items.allDocs(); // Get all documents
		
				const deletePromises = allDocs.rows.map(row => {
					return db_items.remove(row.id, row.value.rev); // Prepare to delete each document
				});
		
				await Promise.all(deletePromises); // Execute all delete operations
				console.log('All documents deleted.');
			} catch (error) {
				console.error('Error deleting documents:', error);
			}
		}
		
		async function processItemAjax(data) 
		{
			postMessage('3');
			console.log('offlineitems' , data);
			
			// deleteAllDocuments();
			 db_items = new PouchDB('phppos_items',{revs_limit: 1});
			 
			var items = JSON.parse(data);
	
			for(var k=0;k<items.length;k++)
			{
				var item = items[k];

				var image_src = item.image_src;
				var has_variations = item.has_variations;
		
				var prod_image = "";
				var image_class = "no-image";
				var item_parent_class = "";
				if (image_src != '' ) {
					var item_parent_class = "item_parent_class";
					var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
					var image_class = "has-image";
				} else {
					image_src =  settings.site_url+ + '/assets/css_good/media/placeholder.png';
				}

				currency_ = item.currency;
				price = (item.price ? ' ' + decodeHtml(item.price) + ' ' : '');
				price_val = (item.price ? decodeHtml(item.price) : '');
				price_val = price_val.replace(currency_, '');
				price_val = parseFloat(price_val.replace(/,/g, ''));
				price_val_reg = (item.regular_price ? decodeHtml(item.regular_price) : '');
					 price_val_reg = parseFloat(price_val_reg.replace(/,/g, ''));
					 var new_item = {
						'_id': item.id+"_item",
						permissions: item.permissions,
						all_data: item,
						name: item.name,
						description: item.description,
						item_id: item.id,
						quantity: 1,
						cost_price: item.cost_price,
						price: price_val,
						orig_price: price_val_reg,
						discount_percent: 0,
						variations: has_variations,
						item_attributes_available: item.item_attributes_available,
						quantity_units: item.quantity_units,
						modifiers: item.modifiers,
						taxes: item.item_taxes,
						tax_included: item.tax_included,
						image_src:image_src
					}

				
				try
				{
					var doc = await db_items.get(items[k].id+"_item");
					new_item['_rev'] = doc._rev;
					await db_items.put(new_item,{force: true});
				}
				catch(error)
				{
					await db_items.put(new_item);
				}	
			}
		
		    await db_items.query('search', {
		      reduce: true
		    });
		
			db_settings.get('offline_item_offset',async function (error, doc) 
			{
				//Keep going
				if (items.length)
				{
					var new_offline_item_offset = {'_id': 'offline_item_offset','value': parseInt(doc.value)+item_limit};
					new_offline_item_offset['_rev'] = doc._rev;
					await db_settings.put(new_offline_item_offset,{force: true});
			
					var url = settings.site_url+'/sales/items_offline_data/'+item_limit+"/"+(parseInt(doc.value)+item_limit);
					ajax(url, {}, processItemAjax, 'POST');
				}
				else
				{
					var new_offline_item_offset = {'_id': 'offline_item_offset','value': 0};
					new_offline_item_offset['_rev'] = doc._rev;
					await db_settings.put(new_offline_item_offset,{force: true});
				
					db_settings.get('items_sync_last_run_time',async function (error2, doc2) 
					{	
						//Put the Date in we just ran so it don't run for a bit
						var new_items_sync_last_run_time = {'_id': 'items_sync_last_run_time','value': Date.now()};
						new_items_sync_last_run_time['_rev'] = doc2._rev;
						await db_settings.put(new_items_sync_last_run_time,{force: true});
					});	
				
				}
		
			});	
		
		}

	}
}
catch(exception_var)
{
	
}



