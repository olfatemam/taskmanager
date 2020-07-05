# taskmanager
 todolist

this is a taskmanager web application, for it to work you need to do the following:
1. download this source and use laravel deployment insttuctions to make it accessible to the web server and having storage bootstrap/cache folders writables
run from the installation folder the command "composer install --no-dev –optimize-autoloader" to install laravel dependancies
 
2. initialize .env Database settings with a freshly created database using your prefererd DB engine, this version is using using mysql database
3.run php artisan migrate to create taskmanager tables

4.4n php artisan db:seed to fill in the lookup tables

5. configure the mail from the .env file

3. add the command "php artisan tasks:remind"  to the db cron jobs to run every 10 minutes to send reminders for approaching tasks due time


5. the first user to register will be granted Admin rights, following registrations will be with 'User' right
6. admin can view/manage tasks for self and all other users
7. admin can change access rights to other users and grant them admin rights or delete them from the system
7. a user can see and manage only his own tasks


TBD:
add fullcalendar to view tasks in a planner like view 

check todo popular websites for ideas, starting with todoist.com

Add change password to the user edit options 
revisit the logic of users removal from the system, a currently, a user may not be removed if he has created tasks by database constraints. should it be allowed and all related tasks e deleted by cascade instead?