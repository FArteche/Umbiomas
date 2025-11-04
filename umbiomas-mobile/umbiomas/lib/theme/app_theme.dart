import 'package:flutter/material.dart';

class AppTheme {
  static final Color primaryColor = Colors.green[800]!;

  static final Color contentBoxColor = Colors.lightGreen[100]!;

  static final Color contentBoxBorderColor = Colors.green[900]!;

  static const LinearGradient backgroundGradient = LinearGradient(
    colors: [Color(0xFFF1F8E9), Colors.white],
    begin: Alignment.topCenter,
    end: Alignment.bottomCenter,
    stops: [0.0, 0.7],
  );
}