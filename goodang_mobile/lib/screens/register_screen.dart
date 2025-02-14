import 'package:flutter/material.dart';
import '../service/auth_service.dart';

class RegisterScreen extends StatefulWidget {
  @override
  _RegisterScreenState createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  // Controllers untuk input
  final TextEditingController nameController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  final TextEditingController confirmPasswordController = TextEditingController();

  bool isLoading = false;
  String errorMessage = '';
  String successMessage = '';

  Future<void> _handleRegister() async {
    setState(() {
      isLoading = true;
      errorMessage = '';
      successMessage = '';
    });

    String name = nameController.text.trim();
    String email = emailController.text.trim();
    String password = passwordController.text.trim();
    String confirmPassword = confirmPasswordController.text.trim();

    // Panggil API register
    final response =
        await AuthService.register(name, email, password, confirmPassword);

    setState(() {
      isLoading = false;
    });

    if (response['success'] == true) {
      setState(() {
        successMessage = 'Registration successful! Please login.';
      });
      Future.delayed(Duration(seconds: 2), () {
        Navigator.pop(context);
      });
    } else {
      setState(() {
        errorMessage = response['message']?.toString() ??
            'Registration failed. Please try again.';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // Background warna biru muda
      backgroundColor: Colors.blue[50],
      body: Center(
        child: SingleChildScrollView(
          child: Container(
            width: 400,
            padding: EdgeInsets.all(16.0),
            child: Card(
              elevation: 8,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
              child: Padding(
                padding: EdgeInsets.all(24.0),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      'Goodang',
                      style: TextStyle(
                        fontSize: 32,
                        fontWeight: FontWeight.bold,
                        color: Colors.blue,
                      ),
                    ),
                    SizedBox(height: 16),
                    Text(
                      'Register a new membership',
                      style: TextStyle(fontSize: 16),
                      textAlign: TextAlign.center,
                    ),
                    SizedBox(height: 24),
                    // Field Name dengan icon
                    TextField(
                      controller: nameController,
                      decoration: InputDecoration(
                        labelText: 'Name',
                        prefixIcon: Icon(Icons.person),
                        border: OutlineInputBorder(),
                      ),
                    ),
                    SizedBox(height: 16),
                    // Field Email dengan icon
                    TextField(
                      controller: emailController,
                      decoration: InputDecoration(
                        labelText: 'Email',
                        prefixIcon: Icon(Icons.email),
                        border: OutlineInputBorder(),
                      ),
                      keyboardType: TextInputType.emailAddress,
                    ),
                    SizedBox(height: 16),
                    // Field Password dengan icon
                    TextField(
                      controller: passwordController,
                      decoration: InputDecoration(
                        labelText: 'Password',
                        prefixIcon: Icon(Icons.lock),
                        border: OutlineInputBorder(),
                      ),
                      obscureText: true,
                    ),
                    SizedBox(height: 16),
                    // Field Confirm Password dengan icon
                    TextField(
                      controller: confirmPasswordController,
                      decoration: InputDecoration(
                        labelText: 'Confirm Password',
                        prefixIcon: Icon(Icons.lock_outline),
                        border: OutlineInputBorder(),
                      ),
                      obscureText: true,
                    ),
                    SizedBox(height: 16),
                    if (errorMessage.isNotEmpty)
                      Text(
                        errorMessage,
                        style: TextStyle(color: Colors.red),
                      ),
                    if (successMessage.isNotEmpty)
                      Text(
                        successMessage,
                        style: TextStyle(color: Colors.green),
                      ),
                    SizedBox(height: 16),
                    // Button Register
                    isLoading
                        ? CircularProgressIndicator()
                        : SizedBox(
                            width: double.infinity,
                            child: ElevatedButton(
                              onPressed: _handleRegister,
                              style: ElevatedButton.styleFrom(
                                backgroundColor: Colors.blue,
                                padding: EdgeInsets.symmetric(vertical: 16),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(4),
                                ),
                              ),
                              child: Text(
                                'Register',
                                style: TextStyle(fontSize: 16, color: Colors.white),
                              ),
                            ),
                          ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}
