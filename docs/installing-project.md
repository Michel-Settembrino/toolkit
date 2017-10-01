# Installing a project

<big><table><thead><tr><th nowrap> [Building the codebase](./building-codebase.md#building-the-codebase) </th><th width="100%" align="center"> [User guide](../README.md#user-guide) </th><th nowrap> [Testing a project](./testing-project.md#testing-a-project) </th></tr></thead></table>

This guide explains how to install a new project or how to 
clone your production website using the toolkit. This guide is intended to be
used in an unix environment.

## Clean installation
With toolkit you can install in few minutes a new project in order to start working
or test some new functionality. The process is quite simple and can be done in
few steps.


<details>
    <summary>execute <code>composer create-project ec-europa/subsite toolkit-demo dev-master</code></summary>
    <p>Toolkit provide a package to make all process easier, this will download and
    install all the tools you need to start working in your project.</p>

</details>
<details>
    <summary>update the file <code>build.project.props</code></summary>
    <p>You should provide in the root of your project a file name build.project.props
    with the global information for your project like: Project ID, platform
    version or Production URL</p>
    <p>You can see an example bellow.</p>
    > Please check this [page](/docs) for more information.

</details>
<details>
    <summary>create the file <code>build.develop.props</code></summary>
    <p>This file should include your local environment information like: data
    connection, website url and others. This file should <strong>never
    be commited to repository</strong>, it is intended to hold private
    information that should not be shared.</p>
    <p>You can see an example bellow.</p>

</details>
<details>
    <summary>execute <code>./toolkit/phing build-project-platform</code></summary>
    <p>Toolkit provide a phing target to build the platform, please refer to targets documentation
    get more details.</p>

</details>
<details>
    <summary>execute <code>./toolkit/phing build-subsite-dev</code></summary>
    <p>Toolkit provide a phing target to build your project, please refer to targets documentation
    get more details.</p>

</details>
<details>
    <summary>execute <code>./toolkit/phing install-project-clean</code></summary>
    <p>Toolkit provide a phing target to install your subsite project, please refer to
    targets documentation get more details.</p>

</details>

&nbsp;

<p>Now put it all together and using terminal we got</p>

```
# Create the project from scratch in a folder name toolkit-demo
$ composer create-project ec-europa/subsite toolkit-demo dev-master
$ cd toolkit-devo

# Edit the file build.project.props to add the required information 
$ vim build.project.props

# Create the build.developer.props and add your local settings there
# touch build.develop.props
$ vim build.develop.props

# Build the platform, subsite and install it though phing
$ ./toolkit/phing build-project-platform build-subsite-dev install-project-clean
```
&nbsp;

## Clone installation
With toolkit you can clone the  production environment of a specif subsite easily.
Some requirements need to be filled to be able to clone:
1. You should have access to repository of the project
2. You should request the ASDA credentials in order to be able to download the daily snapshot

If you don't have the credentials, please request it near your project-manager. 

<details>
    <summary>execute <code>composer create-project ec-europa/subsite toolkit-demo dev-master</code></summary>
    <p>Toolkit provide a package to make all process easier, this will download and
    install all the tools you need to start working in your project.</p>

</details>
<details>
    <summary>update the file <code>build.project.props</code></summary>
    <p>You should provide in the root of your project a file name build.project.props
    with the global information for your project like: Project ID, platform
    version or Production URL</p>
    <p>You can see an example bellow.</p>
    > Please check this [page](/docs) for more information.

</details>
<details>
    <summary>create the file <code>build.develop.props</code></summary>
    <p>This file should include your local environment information like: data
    connection, website url and others. This file should <strong>never
    be commited to repository</strong>, it is intended to hold private
    information that should not be shared.</p>
    <p>You can see an example bellow.</p>

</details>
<details>
    <summary>execute <code>./toolkit/phing build-project-platform</code></summary>
    <p>Toolkit provide a phing target to build the platform, please refer to targets documentation
    get more details.</p>

</details>
<details>
    <summary>execute <code>./toolkit/phing build-subsite-dev</code></summary>
    <p>Toolkit provide a phing target to build your project, please refer to targets documentation
    get more details.</p>
</details>
<details>
    <summary>execute <code>./toolkit/phing install-project-clone</code></summary>
    <p>Toolkit provide a phing target to clone your subsite project, please refer to
    targets documentation get more details.</p>

</details>


<p>
&nbsp;

<p>Example of build.project.props</p>

```
# Subsite configuration example.
# ----------------------

project.id = <my project id here>

project.install.modules = 
project.name = <my project name>
project.url.production = <my production url here>

# Solr configuration.
# -------------------
project.solr.type = d7_apachesolr

# Admin configuration.
# --------------------
project.admin.email = ${project.admin.username}@example.com

# Platform configuration.
# -----------------------
profile = multisite_drupal_standard
platform.package.version = 2.3
```

<p>Example of build.develop.props</p>

```
# Subsite developer configuration example.
# ----------------------

project.url.base = <your local url here>

db.password = <your database password here>
db.host = <your database host  here>

share.path = /tmp/cache

# Database download settings.
# ---------------------------
db.dl.filename = <your asda database dump name here>
db.dl.password = <your-asda-password-here>
db.dl.username = <your-asda-username-here>
```