import 'package:flutter/material.dart';
import '../service/auth_service.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false;
  String errorMessage = '';
  bool rememberMe = false;

  Future<void> _handleLogin() async {
    setState(() {
      isLoading = true;
      errorMessage = '';
    });

    String email = emailController.text.trim();
    String password = passwordController.text.trim();

    // Panggil API login
    final response = await AuthService.login(email, password);

    setState(() {
      isLoading = false;
    });

    if (response['success'] == true) {
      Navigator.pushReplacementNamed(context, '/home');
    } else {
      setState(() {
        errorMessage =
            response['message'] ?? 'Login failed. Please try again.';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // Background warna biru muda seperti tema bootstrap
      backgroundColor: Colors.blue[50],
      body: Center(
        child: SingleChildScrollView(
          child: Container(
            width: 400, // Ukuran lebar card tetap
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
                      'Log-in untuk melanjutkan ke dashboard',
                      style: TextStyle(fontSize: 16),
                      textAlign: TextAlign.center,
                    ),
                    SizedBox(height: 24),
                    // Input Email dengan icon
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
                    // Input Password dengan icon
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
                    // Remember me checkbox
                    Row(
                      children: [
                        Checkbox(
                          value: rememberMe,
                          onChanged: (value) {
                            setState(() {
                              rememberMe = value ?? false;
                            });
                          },
                        ),
                        Text('Remember Me'),
                      ],
                    ),
                    SizedBox(height: 16),
                    if (errorMessage.isNotEmpty)
                      Text(
                        errorMessage,
                        style: TextStyle(color: Colors.red),
                      ),
                    SizedBox(height: 16),
                    // Button Login
                    isLoading
                        ? CircularProgressIndicator()
                        : SizedBox(
                            width: double.infinity,
                            child: ElevatedButton(
                              onPressed: _handleLogin,
                              style: ElevatedButton.styleFrom(
                                backgroundColor: Colors.blue,
                                padding: EdgeInsets.symmetric(vertical: 16),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(4),
                                ),
                              ),
                              child: Text(
                                'Sign In',
                                style: TextStyle(fontSize: 16, color: Colors.white),
                              ),
                            ),
                          ),
                    SizedBox(height: 16),
                    // Link menuju register
                    TextButton(
                      onPressed: () {
                        Navigator.pushNamed(context, '/register');
                      },
                      child: Text('Register a new membership'),
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
