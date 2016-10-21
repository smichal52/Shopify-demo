# Shopify-demo
Simple responsive web page, that uses the shopify API to create a new product.

#### Live version, linked to my own trial account
https://smichal.000webhostapp.com/shopify-demo/

## Analysis
The page consists of several text fields and an image selector, where you can choose a local image file (also works with drag and drop) or enter a url for a remote one.

When the fields are outlined with red border, it means there is an input error for this field. When all the needed fields have been validated, the button to save the new product will be enabled (all the data will also be validated server side).

After pressing the save button, the user will be informed regarding the success or failure of the operation.

## Notes
The api key and password for using the shopify API have been left blank in config.php file, they can be filled along with the appropriate store url to use the demo with any shopify account.

When choosing a local file to use as product image, the data is sent to the server as a base64 encoded string (supported by the API).

All the products that have been created, can be viewed on the web store or the shopify admin page.


