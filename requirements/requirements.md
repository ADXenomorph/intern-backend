# OKR

## Use cases

Create a task
Connect a task to parent
Assign a task
Add progress of a task
Build task tree with percentage
Build task progress by period
Get task completion history
User authorization
User permissions to create/update and assign tasks of a certain level 

create user groups
add user to the group
assign task to the group

create subitems for each task. Key results for example

### Plan

#### Iteration 1
Create a task
Connect a task to parent
Assign a task
Add progress of a task
Build task tree with percentage

#### Iteration 2
authorization
user groups
assigning tasks to the group

## Entities

Task
* task_id
* name
* type
* level ?
* goal
* assignee_id
* parent task id

Task progress
* task_id
* date
* progress

Assignee
* id
* name
* type ?

