Feature: Painting CRUD
  In Order to Create Painting
  As a Front-End
  I need to pass the data of the Painting to the Controller

  Rules:
  - Data Should be in JSON Format
  - Header should be of type Application/JSON


  Scenario: Create a Painting
    Given the backend server is alive
    When I Send JSON File Contains Data
    Then I Should get JSON with result_code equals to HTTP::OK

  Scenario: Update Painting
    Given the backend server is alive
    When I Send JSON File Contains Data contains the Painting ID of 5
    Then I Should get JSON with result_code equals to HTTP::OK

  Scenario: Delete Painting
    Given the backend server is alive
    When I Send JSON File Contains Painting ID of 9
    Then I Should get JSON with result_code equals to HTTP::OK
