# Export large data to CSV using PHP

Exporting large amount of data may cause memory problems or timeout problemes,here a simple solution for this problems

## Description
Due to the large data commonly used PHPexcel package needs to put all the data in order to generate excel After getting in the face of 
large amounts of data generated excel file which is obviously cause memory overflow,
so consider using PHP side to make the output stream while causing the browser to download the form to complete the requirements.
PHP output stream is derived by way of
php://output is a writable output stream allows the program to operate like a file as write the output to the output stream,
PHP will output content stream is sent to the web server and returned to the browser that initiated the request saved as csv file
CSV is the most common file format, it can easily be introduced into a variety of forms and PC database and EXCEL XLS is a proprietary format. CSV file data table row is the row, to generate a data table fields separated by commas.

## Getting Started

### Dependencies

* You have to check if PDO is enabled in your PHP installation ,no other dependency used in PHP
* No other dependencies are required ! 

### Installing
* Clone the project.
* Just copy the files to your public_html folder
* Create credentials.php file with database parameters (host,username,password)

### Executing program

* On your local machine go to http://localhost/huge_export/dashboard.php




## Authors

contact info

 Soffi Zahir
[@zsoffi21](https://twitter.com/zsoffi21)

## Version History


* 0.1
    * Initial Release

## License

This project is licensed under the [NAME HERE] License - see the LICENSE.md file for details

## Acknowledgments

Inspiration, code snippets, etc.
* this project is based on this article [programmersought](https://www.programmersought.com/article/46992171566/)
* [awesome-readme](https://github.com/matiassingers/awesome-readme)
* [PurpleBooth](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2)
* [dbader](https://github.com/dbader/readme-template)
* [zenorocha](https://gist.github.com/zenorocha/4526327)
* [fvcproductions](https://gist.github.com/fvcproductions/1bfc2d4aecb01a834b46)
