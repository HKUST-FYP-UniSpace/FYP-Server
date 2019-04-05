<html>
  <body>
    <!-- write inline custom CSS in the same view file -->
    <style>
      h1 { color: orange; text-decoration: underline; }
      p { color: blue; }
    </style>
    <h1>Dear {{ $name }},</h1>
    <p>Please enter the following verification code in our app to finish the registration process.</p>
    <p>{{ $code }}</p>
    <p>Thank you.</p>
  </body>
</html>
