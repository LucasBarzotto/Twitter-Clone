# Twitter-Clone
A Twitter Clone made using jQuery, PHP, mySQL, AJAX and Bootstrap.

That's the final project of de Udemy's course 'The complete Web Development Course 2.0'. It uses the MVC architecture (Model-View-Controller).

It's live in the following link:

http://pythonexercise123-com.stackstaging.com/

In the uploaded files is necessary to connect your MySQL database in the functions.php's $link = mysqli_connect(); function. Note that the database has the following tables:
 - `users` : id, email, password.
 - `tweets`: id, tweet, userid, datetime.
 - `isFollowing`: id, follower, isFollowing.
