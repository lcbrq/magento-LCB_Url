# LCB_Url
Plugin for custom url management and rewrite fixes

### Sample usage

Add app/etc/routes.xml with following config:

```<?xml version="1.0"?>
<config>

    <default>
        <checkout_cart_index>
            <name>checkout/cart/index</name>
            <route>koszyk</route>
            <defaults>
                <module>checkout</module>
                <controller>cart</controller>
                <action>index</action>
            </defaults>
        </checkout_cart_index>
    </default>

</config>```
