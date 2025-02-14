class User {
  final int id;
  final String name;
  final String email;
  // You can add more fields as needed.

  User({required this.id, required this.name, required this.email});

  // Create a User object from JSON.
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      email: json['email'] ?? '',
    );
  }
}
