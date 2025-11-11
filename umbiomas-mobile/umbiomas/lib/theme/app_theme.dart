import 'package:flutter/material.dart';

class AppTheme {
  static final Color primaryColor = Colors.green[800]!;

  static final Color contentBoxColor = Colors.lightGreen[100]!;

  static final Color contentBoxBorderColor = Colors.green[900]!;

  static final LinearGradient backgroundGradient = LinearGradient(
    colors: [Colors.green[100]!, Colors.lightGreen[50]!],
    begin: Alignment.topCenter,
    end: Alignment.bottomCenter,
    stops: const [0.0, 0.7],
  );
}