#Assignments comments

##Assignment 1.1 - Design changes to checkout
I started really simple. I updated the color of the form labels to blue on mobile and brown on desktop devices.

I've decided to apply styling by extending the parent Magento/blank theme.
It's also possible to apply styling by module, but since we depend heavily on the parent theme in this example, this is the best way to go.

The upside of this approach is that when Magento upgrades to a new version, we have far less work to apply all changes in our custom theme.
The downside of this approach is that when a design is strict, an update by Magento means our design is updated too, which we don't want in that case.

##Assignment 1.2 - Design changes to cart
Let's remove the 'clear cart' button, because when users have spent an hour filling their cart and they mistake it for the update button the're not happy :(

We have to override the template of the cart form, because the button can't be removed with the layout file since it's not a block

##Assignment 1.3 - Design changes to product overview
We don't want to use layered navigation, so let's remove the complete sidebar on the product overview page. Now we can also use the 1column layout because we have no left column anymore.
I've also removed the add to wishlist and add to compare buttons from the items so the add to cart button really popus up.

##Assignment 1.4 - Design changes to product detail
We want to add a list of the 5 newest products in our store at the bottom of the product detail page.

I have used the widget that Magento provides, but I have inserted it through layout.xml instead of through the database (admin) like you would normally do with a widget.
To set the maximum items to 5 I have created an action that calls the 'setProductsCount' function in the block.

Note; don't do this in a production website, because all product pages will be invalidated in Varnish when a new product is added or a newer product is changed.

##Assignment 2.1 - Create module for extra column in order table
I have created a module that adds a column to the sales_order table and makes it available in the order grid where it can be filtered.
Excuse me for the lack of possibility to enter a remark on the frontend. I would have added a field in the checkout and copied the value from the quote to the order, but due to time this part is not done.

You can edit the remark through the API though. Send a PUT request to : /rest/V1/orders/{order_id}/remarks
With the body:
`{"remarks": {"remarks": "Afleveren bij de buren"}}`

There is a special permission needed to edit a remark for an order since there is no permission to edit an order.

Also; I did not use /rest/V1/orders/{order_id} (so without the /remark) because it is a core concept that an order can **not** be changed. It can only be updated by the 'flow' of creating invoices and shipments, but never edited by a user.

To improve the module I would rename it to ESTG_OrderRemarks (I did not have inspriration on the column name when I started the module). 

##Assignment 2.2 - Add stock notice to product detail page
In high traffic and high available webshops my advise would be to not do this. Magento purges the product detail page and all category pages by default when it's sold, but you don't want to do that. Displaying the amount of stock doesn't help in that requirement.

But if we want to display the quantity left, we have to use the new inventory module, since the cataloginventory is deprecated.
Since stock can be from multiple sources I have to loop through all the sources to get the sum of all stocks. By default an order will be dispatched over all available sources, so this is the actual maximum a customer can order through the website.

I have used two kinds of operations to set the default value of configuration. By adding the 'enabled' status to the config.xml and to the config.php it is not possible to change it through the admin. By adding the stock level only to config.php it is set as default, but it is possible to be changed in the admin.

I've also used a second configuration to enable or disable the feature and added it to the layout.xml. In this case the whole block won't get instanciated when the configuration is put on disabled.
