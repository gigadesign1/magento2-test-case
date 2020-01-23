#Assignments comments

##Assignment 1.1 - Design changes to checkout
I started really simple. I updated the color of the form labels to blue on mobile and brown on desktop devices.

I've decided to apply styling by extending the parent Magento/blank theme.
It's also possible to apply styling by module, but since we depend heavily on the parent theme in this example, this is the best way to go.

The upside of this approach is that when Magento upgrades to a new version, we have far less work to apply all changes in our custom theme.
The downside of this approach is that when a design is strict, an update by Magento means our design is updated too, which we don't want in that case.