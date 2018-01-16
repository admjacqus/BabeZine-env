# Turtorial :sparkles::turtle::sparkles:

Wordpress environment for Theme development. 

## Getting Started

These instructions will help you to install MAMP & Wordpress locally for a really easy to use build environemnt, with loads of cool build tools.

### First time Set Up

To build your testing environment, you will ned to install some bits & bobs locally, follow steps below. Once this is set-up, the repo has somewhere to live.

* [WordPress](https://wordpress.org/download/) - Blog platform.
* [MAMP](https://www.mamp.info/en/downloads/) - Local Websever.
* [npm](https://docs.npmjs.com/getting-started/installing-node) - Build Tools.



#### Step 1: Get WP
First we need the latest WordPress verison, click the link above and place the ZIP file in your 'Sites' folder. Pick wherever you want to keep your working directory, but it's 'Sites' for this tutorial.

#### Step 2: Get MAMP
Download MAMP from the link above, install in your Applications folder. (Mac OS X 10.6.6 or later.) You'll probably need the admin password.

#### Step 3: Launch MAMP
Launch MAMP, Go into your Applications folder and click the MAMP folder. Click on the elephant MAMP icon, which will open MAMP control panel. Ignore MAMP Pro, stick to the grey, standard MAMP. This will open the MAMP control panel.

#### Step 4: Setup Ports
Click Preferences, and make sure the Ports tab is selected. Ports should be set on the default: 8888 for Apache, and 8889 for MySQL. If not, either enter manually or click 'Set MAMP ports to default'.

#### Step 5: Setup Document root
Now, you’ll need to set the document root. The default document root is:

```Macintosh HD > Applications > MAMP > htdocs```

Let's change that to the folder you picked in Step 1.

To change/set the document root, click the gray folder icon with the three white dots. A finder window will appear, where you can select the document root.

The folder path would be: Users > user.name > Sites

#### Step 6: Start your engines
Click 'Start Servers' from the MAMP control panel. You should see in the top right of the window, the boxes next to Apache Server and MySQL sever are filled green.

If the start page does not open automatically, just click 'Open start page'.

#### Step 6: Setup a MySQL database
There are two options of getting to phpMyAdmin:

Visit the URL http://localhost:8888/phpMyAdmin
Or on the MAMP start page in your browser, click the phpMyAdmin link

You should see these three in the side panel:

* New
* information_schema
* mysql
* performance_schema

Now you want to create a database for your local WordPress site. Click on the databases tab on the far left of the top navigation, or the 'New' tab.

Underneath 'Create database', enter the database name and click "create".

```babeZine_db```

#### Step 8: Unzip WP
Remeber the ZIP from Step 1, I know right?? Well unzip that, and rename the resulting "wordpress" folder, "BabeZine".
You should now have a folder within your working directory, in our case 'Sites', called "BabeZine" with the guts of WordPress within.

``` ~/Sites/BabeZine/ ```

#### Step 8: The 5min Install
OK, your server should still be up, if not click the 'Start Servers' button & wait for your servers to start up.

You can now, in your prefered browser, go to  [https://localhost:8888/BabeZine](https://localhost:8888/BabeZine)

Select your Language, then on the next screen, your Database info from Step 6.

* Database Name = babeZine_db
* User Name = root
* Password = root
* Tabel Prefix = _wp

Click "submit"

Now, enter the Site Title and your prefered credentials. This is what you will use to log in to the WordPress dashboard later, so make a note of these. (Your site is local so don't worry about Privacy)

* Site Title = Missguided

Click "Install WordPress"

Now, let's run through what we've done. You now have a local server running on your machine, which hosts a MySQL database and WordPress. The databse has stored your login credentials, and WordPress is at your beck-and-call. To create a carbon copy of the live Missgudied Blog, we will now replace some of the core WordPress files with those fo the real thing.

#### Step 9: Clone the Repo

In terminal run the following commands;

```$ cd ~/Sites/BabeZine
$ git clone https://github.com/ishiiprints/MG-Blog.git```

### Step 10: Replace
Does git overwrite everything it needs to? I dunno I'm too tired now.







