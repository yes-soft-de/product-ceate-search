Feature: Painting Search
  In Order to Create Painting
  As a Front-End
  I need to pass the data of the Painting to the Controller

  Rules:
  - Server Should be Online
  - Data Should be in JSON Format
  - Header should be of type Application/JSON


  Scenario: Search a Painting
    Given the backend server is alive
    When i Search for Painting with Query Message "Over"
    Then i Should Get a StatusCode of 200

  Scenario: Get Latest Paintings
    Given the backend server is alive
    When i Request Latest Painting
    Then i Should Get a StatusCode of 200