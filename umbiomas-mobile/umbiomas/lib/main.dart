import 'package:flutter/material.dart';
import 'screens/biomas_screen.dart'; // Importe sua nova tela

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'EmBiomas App',
      theme: ThemeData(
        primarySwatch: Colors.green, // Define a cor principal do app
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: BiomasScreen(), // Define a tela inicial
      debugShowCheckedModeBanner: false, // Remove o banner de debug
    );
  }
}