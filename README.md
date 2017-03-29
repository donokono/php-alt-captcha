# CAPTCHA alternative using random photos in PHP

## What is it?

This simple PHP class randomly selects 9 images of various 'things', superimposes a three-digit number on top of each image and generates a single 300 x 300 pixel image made up of the 9 smaller images.
  
The object created by calling the `makeImage()` method contains properties you can use to implement a clever CAPTCHA scheme where the user has to enter the three-digit number next to a specified 'thing'. The idea is that an actual human has to identify the 'thing' and enter the number next to it. Something registration bots might have a difficult time doing.
  
This is the latest version of the class which outputs a base64 representation of the final confirmation image.

## Usage

Take a look at test.php for an example of how to use the class. It should be pretty straightforward.

## Images

The `things` directory contains a bunch of 100 x 100 pixel PNG files that are named with the 'thing' found in the image. So, the image file of a ball is named `ball.png`.

## Caveats

A few thoughts while building this. I realize that users that are visually impaired will not be able to use this CAPTCHA scheme. If you decide to implement something like this for your Web site, please take note of this important fact.
 
I really tried to make all the items in the photos as simple as possible in hopes that non-native English speakers will still be able to use the scheme with a super basic understanding of English. If the rest of your site is English only, you should be OK.


