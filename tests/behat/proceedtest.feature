@tool @tool_lifecycle
Feature: Add a workflow with an adminapprove step and test it

  Background:
    Given the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
      | Course 2 | C2        |
      | Course 3 | C3        |
      | Course 4 | C4        |
    And I log in as "admin"
    And I navigate to "Life Cycle > Workflow Settings" in site administration
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

  Scenario: Test interaction of email step
    When I am on "/admin/tool/lifecycle/step/adminapprove/index.php"
    Then I should see "Nothing to Display"
    When I run the scheduled task "tool_lifecycle\task\lifecycle_task"
    And I am on "/admin/tool/lifecycle/step/adminapprove/index.php"
    And I click on "Admin Approve Step" "text"
