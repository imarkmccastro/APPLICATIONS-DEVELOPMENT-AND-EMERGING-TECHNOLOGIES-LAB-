# PSA5 PHP Technical Questions

**1. What is the usage of super global?**
Superglobals (like `$_GET`, `$_POST`, `$_SESSION`) are built-in PHP variables that are accessible from anywhere in the script without needing the `global` keyword. They are used to access form data, session data, and server information.

**2. What are the differences between $_POST and $_GET?**
* **$_GET:** Appends data directly to the URL (making it visible and less secure), has a strict character length limit, and can be bookmarked.
* **$_POST:** Sends data invisibly via the HTTP request body (making it more secure), has no strict size limit (ideal for file uploads), and cannot be bookmarked.

**3. What is the importance of cookies on a webpage or website?**
Cookies are small files stored directly on the user's browser. They are important because they allow a website to "remember" user preferences (like language or dark mode) and track data across multiple visits.

**4. What is a session?**
A session is a mechanism used to temporarily store user data securely on the server-side across multiple pages. The user's browser is simply given a unique "Session ID" to retrieve this data.

**5. What is the importance of session?**
Sessions are vital for web security and authentication (such as keeping a user logged in). They are important because sensitive data is hidden safely on the server rather than exposed or easily tampered with in the user's browser.
