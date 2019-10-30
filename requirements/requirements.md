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

### Plan

#### Iteration 1
Create a task
Connect a task to parent
Assign a task
Add progress of a task
Build task tree with percentage

#### Iteration 2
...

## Entities

Task
* task_id
* name
* type
* level ?
* assignee_id

Task progress
* task_id
* date
* progress ?

Assignee
* id
* name
* type ?
  
Task tree
* task id
* parent task id

