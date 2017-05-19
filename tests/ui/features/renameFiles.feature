Feature: renameFiles

	Scenario Outline: Rename a file using special characters
		Given a regular user exists
		And I am logged in as a regular user
		And I am on the files page
		When I rename the file "lorem.txt" to <to_file_name>
		Then the file <to_file_name> should be listed
		Examples:
		|to_file_name  |
		|'लोरेम।तयक्स्त $%&'    |
		|'"quotes1"'   |
		|"'quotes2'"   |

		
	Scenario Outline: Rename a file that has special characters in its name
		Given a regular user exists
		And I am logged in as a regular user
		And I am on the files page
		When I rename the file <from_name> to <to_name>
		Then the file <to_name> should be listed
		Examples:
		|from_name                            |to_name                              |
		|"strängé filename (duplicate #2).txt"|"strängé filename (duplicate #3).txt"|
		|"'single'quotes.txt"                 |"single-quotes.txt"                  |
		|'"double"quotes.txt'                 |'double-quotes.txt'                  |

	Scenario: Rename a file using special characters check its existence after page reload
		Given a regular user exists
		And I am logged in as a regular user
		And I am on the files page
		When I rename the file "lorem.txt" to "लोरेम।तयक्स्त $%&"
		And the page is reloaded
		Then the file "लोरेम।तयक्स्त $%&" should be listed

	Scenario: Rename a file using forbidden characters
		Given a regular user exists
		And I am logged in as a regular user
		And I am on the files page
		When I rename the file "data.zip" to one of these names
		|lorem/txt  |
		|.htaccess  |
		|lorem\txt  |
		|\\.txt     |
		Then notifications should be displayed with the text
		|Could not rename "data.zip"|
		|Could not rename "data.zip"|
		|Could not rename "data.zip"|
		|Could not rename "data.zip"|
		And the file "data.zip" should be listed

	Scenario: Rename a file putting a name of a file which already exists
		Given a regular user exists
		And I am logged in as a regular user
		And I am on the files page
		When I rename the file "data.zip" to "lorem.txt"
		Then near the file "data.zip" a tooltip with the text 'lorem.txt already exists' should be displayed