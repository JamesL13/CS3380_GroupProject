CS3380_GroupProject
===================

Web app for Tonys Pizza:

If you have an SSH key already tied to your personal babbage account make sure that is added to GitHub
I am using the same key from my Software Engineering group project.

If you need a key or more information: https://help.github.com/articles/generating-ssh-keys/

To push whatever you are working on up to GitHub do using command line:

git@github.com:gmgq72/CS3380_GroupProject.git  //only do this once to clone the repository to a new system. Will create a folder directory in whatever directory you are in currently.

git init //initializes the repository. May or may not have to do this at the beginning every time

git pull origin master //update the local copy of the repository. DO THIS EVERYTIME BEFORE YOU ADD TO MASTER BRANCH

git checkout -b *branchName* (Enter, git checkout *branchName*, to move into this branch from here on out)

vim *files you want to create*

git add FILENAME.txt (php)(html)(etc)

commit -m "add a description of what was changed here".

-----------------------------------------------------------------------------------------------
---------- ONLY DO THIS IF YOU'RE READY TO MERGE YOUR GOOD WORKING CODE TO MASTER -------------
---------- YOU HAVE THE POTENTIAL TO BREAK THE MASTER; DO NOT MERGE/PUSH BROKEN CODE!!! -------
---------- MAKE SURE TO PULL THE LATEST MASTER BEFORE MERGING YOUR BRANCH TO MASTER -----------
-----------------------------------------------------------------------------------------------

git checkout master //Navigate to master branch to push your branch to master

git merge *branchName*

//Fix merge conflicts if any arise

git push origin master //This solidifies your branch to the master and is permanent. BE CAREFUL!