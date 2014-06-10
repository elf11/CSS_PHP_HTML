<div id="addCommentContainer">
	<p>Add a Comment</p>
	<form id="addCommentForm" method="post" action="">
    	<div>
        	<label for="name">Your Name</label>
        	<input type="text" name="name" id="name" />
            
            <label for="email">Your Email</label>
            <input type="text" name="email" id="email" />

            <label for="body">Comment Body</label>
            <textarea name="body" id="body" cols="20" rows="5"></textarea>

            <input type='hidden' name='artid' id='artid' value='<? echo $_GET["id"]; ?>' />
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>