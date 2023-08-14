<?php
    $pageTitle = "Search Book- Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Find a Book</h1>
    <hr>
    <form action="search_books.php" method="GET" class="search-bar">
        <!-- <label for="search_query">Search by Title or Author:</label> -->
        <input type="text" name="search_query" id="search_query" placeholder="Search by Title or Author" required>
        <input type="submit" name="submit" value="Search">
    </form>

    <section class="containercards">

        <div class="card"> 
            <div class="card-image car-1"></div>
            <h2 class="movietitle">Twilight Saga</h2>
            <p class="moviepara"> "Twilight": Bella's vampire love, Edward, challenges norms. Their unique romance intertwines danger and devotion in this captivating supernatural tale.</p>
            <a href = "" class="linke">READ MORE</a>  
        </div>
           
        <div class="card"> 
            <div class="card-image car-2"></div>
            <h2 class="movietitle" >Harry Potter and Half-Blood Prince</h2>
            <p class="moviepara">"Half-Blood Prince": Voldemort's origins explored. Dumbledore guides Harry. Secrets deepen, alliances shift, setting stage for final confrontation. </p>
            <a href="" class="linke">READ MORE</a>    
        </div>
           
        <div class="card"> 
            <div class="card-image car-3"></div>
            <h2 class="movietitle">Hobbit</h2>
            <p class="moviepara">"The Hobbit": Bilbo joins dwarves' quest for treasure, grows brave. Battles creatures, finds courage in epic adventure.</p>
            <a href="" class="linke">READ MORE</a>  
        </div>
           
        <div class="card"> 
            <div class="card-image car-4"></div>
            <h2 class="movietitle">The Adventuers of Huckleberry finn</h2>
            <p class="moviepara">"Huckleberry Finn" follows Huck's escape with Jim, a runaway slave. Journey unfolds social commentary, friendship, and freedom.</p>
            <a href="" class="linke" >READ MORE</a>  
        </div>
       
        <div class="card"> 
            <div class="card-image car-5"></div>
            <h2 class="movietitle">Heroes of Olympus The lost hero</h2>
            <p class="moviepara">"In 'Heroes of Olympus: The Lost Hero,' demigods quest to rescue Hera, facing challenges, forging bonds, and uncovering ancient mysteries."</p>
                <a href="" class="linke" >READ MORE</a>  
        </div>
              
        <div class="card"> 
            <div class="card-image car-6"></div>
            <h2 class="movietitle">The Hunger Games</h2>
            <p class="moviepara" >"In a post-apocalyptic society, 'The Hunger Games' annually pits teens against each other. Katniss Everdeen's sacrificial choice thrusts her into the deadly arena, challenging authority and kindling a rebellion against oppression."</p>
            <a href="" class="linke" >READ MORE</a> 
        </div>
                       
        <div class="card"> 
            <div class="card-image car-7"></div>
            <h2 class="movietitle" >Percy Jackson and The Titans Curse</h2>
            <p class="moviepara">In "Percy Jackson: Titan's Curse," Percy joins friends to rescue Artemis, battling Titans. Quest unfolds dangers, tests loyalties, reveals secrets in gripping mythological adventure.</p>
            <a href="" class="linke" >READ MORE</a>             
        </div>

        <div class="card"> 
            <div class="card-image car-8"></div>
            <h2 class="movietitle" >Mother</h2>
            <p class="moviepara">Maxim Gorky's "Mother" portrays working-class hardship and revolt in pre-revolution Russia. Protagonist Nilovna transforms from submissive wife to revolutionary, reflecting societal upheaval and individual empowerment.</p>
            <a href="" class="linke" >READ MORE</a>             
        </div>
    </section>
</div>

<?php
    include 'footer.php';
?>