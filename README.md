
# Free Range Wordpress Code Challenge

The purpose of this challenge is to test and measure a WordPress engineer's ability to interpret and implement the functionality based off requirements. We will present you with a challenge that is intended to showcase your engineering prowess and spark creative reasoning to problem solving. We will be observing both the thought process behind the solution as well as the final product.

## The Scenario

A company asked you to create a solution for their existing website that let's them add a section on any page that shows their available "Books" in such a way that people can filter the list by title and/or description and by "Category" of the Books as well. They have a website built using the Gutenberg editor so they would like a block to showcase such section on their site. They want to be able to use this block in different pages of the site so the block should have a field to add a title and a description field above the table so that they can use this section for marketing purposes. 

## Requirements

- The plugin must define a custom post type called Books as well as a custom taxonomy called Book Category.
- The post type should use Advanced Custom Fields to define a description textarea field for any Book post (Advanced Custom Fields plugin added to the repository).
- The plugin must create a gutenberg block called Book Listing that shows the UI of a table with the book's name and the description as well as a dropdown to filter by Book Category and a search field to filter by title and/or description.
- The plugin must use the Advanced Custom Fields Block definition to create the gutenberg block (https://www.advancedcustomfields.com/resources/blocks/) and the search logic does not need to rely on any ajax functionality. (Although it's a plus :) )

## Criteria to Evaluate
- _PHP:_ The strategy and organization of your PHP code 
- _WordPress:_ Implementation of WordPress best practices
- _Readability:_ How well can another person understand what each function does and how well are the intricacies of the solution explained to another developer
- _JavaScript:_ the elegance and performance of any JavaScript added
- _HTML:_ Your knowledge of best HTML practices
- _Creativity:_ Your creative intuition to "fill in the gaps" of anything missing on the requirements

## Get Started
- Clone the repo and download the latest version of Wordpress and paste it on the root folder
- Remember to enable the ACF plugin
- Start working on the folder called Free-Range-Code-Challenge under wp-content/plugins
- Create a Pull Request on a different branch with the solution to the challenge
- Have fun! :) 
