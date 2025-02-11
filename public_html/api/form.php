<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client</title>
</head>
<body>
    <h1>TESTEN</h1>
    
    <h2>Client</h2>
    <h3>Add</h3>
    <form action="index.php/client/add" method="POST" id="addClientForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="width">width:</label><br>
        <input type="number" id="width" name="width"><br><br>

        <label for="height">Height:</label><br>
        <input type="number" id="height" name="height"><br><br>

        <label for="xPosition">X Position:</label><br>
        <input type="number" id="xPosition" name="xPosition"><br><br>

        <label for="yPosition">Y Position:</label><br>
        <input type="number" id="yPosition" name="yPosition"><br><br>

        <label for="status">Status:</label><br>
        <input type="checkbox" id="status" name="status"><br><br>

        <button type="submit">add Client</button>
    </form>

    <h3>update</h3>
    <form action="index.php/client/update" method="POST" id="updateClientForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="id">Client ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="width">width:</label><br>
        <input type="number" id="width" name="width"><br><br>

        <label for="height">Height:</label><br>
        <input type="number" id="height" name="height"><br><br>

        <label for="xPosition">X Position:</label><br>
        <input type="number" id="xPosition" name="xPosition"><br><br>

        <label for="yPosition">Y Position:</label><br>
        <input type="number" id="yPosition" name="yPosition"><br><br>

        <label for="status">Status:</label><br>
        <input type="checkbox" id="status" name="status" value="1"><br><br>

        <label for="times_used">times used:</label><br>
        <input type="number" id="times_used" name="times_used"><br><br>

        <label for="joined_at">joined at:</label><br>
        <input type="text" id="joined_at" name="joined_at"><br><br>
        
        <button type="submit">update Client</button>
    </form>

    <h3>delete</h3>
    <form action="index.php/client/delete" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">delete</button>
    </form>

    <h3>get</h3>
    <form action="index.php/client/get" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="order">order (ASC, DESC):</label><br>
        <input type="text" id="order" name="order" ><br><br>

        <label for="by">by (id, name,...):</label><br>
        <input type="text" id="by" name="by" ><br><br>

        <label for="limit">limit:</label><br>
        <input type="number" id="limit" name="limit" ><br><br>

        <button type="submit">get</button>
    </form>

    <h3>get specific</h3>
    <form action="index.php/client/getThis" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">get</button>
    </form>


    <h2>Content</h2>
    <h3>Add</h3>
    <form action="index.php/content/add" method="POST" id="addContentForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="type">Type:</label><br>
        <input type="number" id="type" name="type"><br><br>

        <label for="width">width:</label><br>
        <input type="number" id="width" name="width"><br><br>

        <label for="height">Height:</label><br>
        <input type="number" id="height" name="height"><br><br>

        <label for="data">data:</label><br>
        <input type="text" id="data" name="data"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>


        <button type="submit">add Content</button>
    </form>

    <h3>update</h3>
    <form action="index.php/content/update" method="POST" id="updateContentForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="id">Content ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type"><br><br>

        <label for="width">width:</label><br>
        <input type="number" id="width" name="width"><br><br>

        <label for="height">Height:</label><br>
        <input type="number" id="height" name="height"><br><br>

        <label for="data">data:</label><br>
        <input type="text" id="data" name="data"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>

        <label for="times_used">times used:</label><br>
        <input type="number" id="times_used" name="times_used"><br><br>

        <label for="last_use">last use:</label><br>
        <input type="text" id="last_use" name="last_use"><br><br>

        <button type="submit">update Content</button>
    </form>

    <h3>delete</h3>
    <form action="index.php/content/delete" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">delete</button>
    </form>

    <h3>get</h3>
    <form action="index.php/content/get" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="order">order (ASC, DESC):</label><br>
        <input type="text" id="order" name="order" ><br><br>

        <label for="by">by (id, name,...):</label><br>
        <input type="text" id="by" name="by" ><br><br>

        <label for="limit">limit:</label><br>
        <input type="number" id="limit" name="limit" ><br><br>

        <button type="submit">get</button>
    </form>

    <h3>get specific</h3>
    <form action="index.php/content/getThis" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">get</button>
    </form>


    <h2>Playlist</h2>
    <h3>get</h3>
    <form action="index.php/playlist/get" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="table">Table:</label><br>
        <input type="text" id="table" name="table"><br><br>

        <label for="order">order (ASC, DESC):</label><br>
        <input type="text" id="order" name="order" ><br><br>

        <label for="by">by (id, name,...):</label><br>
        <input type="text" id="by" name="by" ><br><br>

        <label for="limit">limit:</label><br>
        <input type="number" id="limit" name="limit" ><br><br>

        <button type="submit">get</button>
    </form>

    <h3>get Specific</h3>
    <form action="index.php/playlist/getThis" method="POST" id="addPlaylistForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="table">Table:</label><br>
        <input type="text" id="table" name="table"><br><br>

        <label for="id">ID:</label><br>
        <input type="number" id="id" name="id"><br><br>

        <button type="submit">get</button>
    </form>

    <h3>delete</h3>
    <form action="index.php/playlist/delete" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="table">Table:</label><br>
        <input type="text" id="table" name="table"><br><br>

        <label for="id">ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">delete</button>
    </form>

    <h3>Add Playlist</h3>
    <form action="index.php/playlist/addPlaylist" method="POST" id="addPlaylistForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>

        <label for="created_by">created_by (id):</label><br>
        <input type="number" id="created_by" name="created_by"><br><br>

        <button type="submit">add Playlist</button>
    </form>

    <h3>update Playlist</h3>
    <form action="index.php/playlist/updatePlaylist" method="POST" id="updatePlaylistForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">Playlist ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="times_used">times used:</label><br>
        <input type="number" id="times_used" name="times_used"><br><br>

        <label for="last_use">last use:</label><br>
        <input type="text" id="last_use" name="last_use"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>

        <button type="submit">update Playlist</button>
    </form>

    <h3>Add Playlist_Contains</h3>
    <form action="index.php/playlist/addPlaylistContains" method="POST" id="addPlaylistContainsForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="content_id">content_id (id):</label><br>
        <input type="number" id="content_id" name="content_id"><br><br>

        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>

        <button type="submit">add playlist_containst</button>
    </form>

    <h3>update Playlist_Contains</h3>
    <form action="index.php/playlist/updatePlaylistContains" method="POST" id="updatePlaylistContainsForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">Playlist_Contains ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="content_id">content_id (id):</label><br>
        <input type="number" id="content_id" name="content_id"><br><br>

        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <label for="duration">duration:</label><br>
        <input type="number" id="duration" name="duration"><br><br>

        <button type="submit">update playlist_containst</button>
    </form>

    <h3>Add Plays_on</h3>
    <form action="index.php/playlist/addPlaysOn" method="POST" id="addPlaysOnForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="client_id">client_id (id):</label><br>
        <input type="number" id="client_id" name="client_id"><br><br>

        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <button type="submit">add Plays_on</button>
    </form>

    <h3>update Plays_on</h3>
    <form action="index.php/playlist/updatePlaysOn" method="POST" id="updatePlaysOnForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">plays_on ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="client_id">client_id (id):</label><br>
        <input type="number" id="client_id" name="client_id"><br><br>

        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <button type="submit">update Plays_on</button>
    </form>

    <h3>Add play_playlist</h3>
    <form action="index.php/playlist/addPlayPlaylist" method="POST" id="addPlayPlaylistForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <label for="start">start:</label><br>
        <input type="text" id="start" name="start"><br><br>

        <button type="submit">add play_playlist</button>
    </form>

    <h3>update play_playlist</h3>
    <form action="index.php/playlist/updatePlayPlaylist" method="POST" id="updatePlayPlaylistForm">
        <input type="hidden" name="_method" value="POST">
        
        <label for="id">Play_Playlist ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="playlist_id">playlist_id (id):</label><br>
        <input type="number" id="playlist_id" name="playlist_id"><br><br>

        <label for="start">start:</label><br>
        <input type="text" id="start" name="start"><br><br>

        <button type="submit">update play_playlist</button>
    </form>


    <h2>User</h2>

    <h3>get</h3>
    <form action="index.php/user/get" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 

        <label for="order">order (ASC, DESC):</label><br>
        <input type="text" id="order" name="order" ><br><br>

        <label for="by">by (id, name,...):</label><br>
        <input type="text" id="by" name="by" ><br><br>

        <label for="limit">limit:</label><br>
        <input type="number" id="limit" name="limit" ><br><br>

        <button type="submit">get</button>
    </form>

    <h3>get specific</h3>
    <form action="index.php/user/getThis" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">get</button>
    </form>

    <h3>delete</h3>
    <form action="index.php/user/delete" method="POST" id="updateClientStatusForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">id:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <button type="submit">delete</button>
    </form>

    <h3>Add</h3>
    <form action="index.php/user/add" method="POST" id="addUserForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="username">username:</label><br>
        <input type="text" id="username" name="username"><br><br>

        <label for="password">password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="rights">rights:</label><br>
        <input type="number" id="rights" name="rights"><br><br>

        <button type="submit">add user</button>
    </form>

    <h3>update</h3>
    <form action="index.php/user/update" method="POST" id="updateContentForm">
        <input type="hidden" name="_method" value="POST"> 
        
        <label for="id">user ID:</label><br>
        <input type="number" id="id" name="id" ><br><br>

        <label for="username">username:</label><br>
        <input type="text" id="username" name="username"><br><br>

        <label for="password">password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="rights">rights:</label><br>
        <input type="number" id="rights" name="rights"><br><br>

        <label for="times_used">times used:</label><br>
        <input type="number" id="times_used" name="times_used"><br><br>

        <label for="last_online">last use:</label><br>
        <input type="text" id="last_online" name="last_online"><br><br>

        <button type="submit">update Content</button>
    </form>
</body>
</html>
