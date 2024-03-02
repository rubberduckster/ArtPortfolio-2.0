<?php
function layout($content)
{
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drawings</title>
    <link rel="stylesheet" href="/style.css">
  </head>

  <body>
    <header class="header">
      <div class="header-section"></div>
      <div class="header-section">
        <a href="/" style="text-decoration: none;">
          <h1>
            <span>[</span>
            Rubberducky
            <span>]</span>
          </h1>
        </a>
      </div>
      <div class="header-section">
        <div class="nav-bar">
          <span>
            <a href="/work/drawings">
              Work
            </a>
          </span>
          <span>
            <a href="/about.html">
              About
            </a>
          </span>
        </div>
      </div>
    </header>
    <div class="content">
      <?php
      echo $content;
      ?>
    </div>
  </body>

  </html>
  <?php
}