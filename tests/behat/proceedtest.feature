@lifecyclestep @lifecyclestep_adminapprove @javascript
Feature: Add a workflow with an adminapprove step and test it

  Background:
    Given the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
      | Course 2 | C2        |
      | Course 3 | C3        |
      | Course 4 | C4        |
    And I log in as "admin"
    And I navigate to "Plugins > Life Cycle > Workflow Settings" in site administration
    And I press "Add Workflow"
    And I set the following fields to these values:
      | Title                    | Admin Approve Step WF #1 |
      | Displayed workflow title | Admin Approve Step WF #1 |
    And I press "Save changes"
    And I select "Start date delay trigger" from the "triggername" singleselect
    And I set the following fields to these values:
      | Instance Name   | My Trigger |
      | delay[number]   | 0          |
      | delay[timeunit] | seconds    |
    And I press "Save changes"
    And I select "Admin Approve Step" from the "stepname" singleselect
    And I set the following fields to these values:
      | Instance Name | Admin Approve Step #1 |
    And I press "Save changes"
    And I select "Delete Course Step" from the "stepname" singleselect
    And I set the field "Instance Name" to "Delete Course #1"
    And I press "Save changes"
    And I press "Back"
    And I press "Activate"

  Scenario: Test interaction of admin approve step
    When I navigate to "Plugins > Life Cycle > Manage Admin Approve Steps" in site administration
    Then I should see "There are currently no steps waiting for interaction."
    When I run the scheduled task "tool_lifecycle\task\lifecycle_task"
    And I reload the page
    And I click on "Admin Approve Step #1" "link"
    Then I should see "Course 1"
    And I should see "Course 2"
    And I should see "Course 3"
    And I should see "Course 4"
    When I click on the tool "Proceed" in the "Course 1" row of the "lifecyclestep_adminapprove-decisiontable" table
    And I wait to be redirected
    Then I should not see "Course 1"
    When I click on the tool "Rollback" in the "Course 2" row of the "lifecyclestep_adminapprove-decisiontable" table
    And I wait to be redirected
    Then I should not see "Course 2"