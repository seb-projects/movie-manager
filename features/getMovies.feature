Feature:
  Scenario: I retrieve movies
    Given I get movies
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I retrieve movies with genre filter
    Given I post form filter with:
      | genre  |
      | Sci-Fi |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I retrieve movies with list filter
    Given I post form filter with:
      | list              |
      | top_boxoffice_200 |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I retrieve movies with year filter
    Given I post form filter with:
      | year |
      | 2023 |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I retrieve movies with title filter
    Given I post form filter with:
      | title         |
      | The Lion King |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I retrieve movies with keyword filter
    Given I post form filter with:
      | keyword |
      | jedi    |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I try to retrieve movies with keyword filter
    Given I post form filter with:
      | keyword   |
      | test12345 |
    Then the response code should be 200
    And the response not contains movies

  Scenario: I retrieve movies with page filter
    Given I post form filter with:
      | page |
      | 2    |
    Then the response code should be 200
    And the response contains at least one movie

  Scenario: I try to retrieve movies with page filter
    Given I post form filter with:
      | page  | keyword |
      | 5     | jedi    |
    Then the response code should be 200
    And the response not contains movies
