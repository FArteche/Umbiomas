// lib/main.dart
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:umbiomas/screens/main_menu_screen.dart';
import 'package:umbiomas/theme/app_theme.dart';
import 'package:intl/date_symbol_data_local.dart';
void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await initializeDateFormatting('pt_BR');
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'UmBiomas App',
      theme: ThemeData(
        useMaterial3: true,
        colorScheme: ColorScheme.fromSeed(
          seedColor: AppTheme.primaryColor,
          brightness: Brightness.light,
          primaryContainer: Colors.green[100],
          onPrimaryContainer: Colors.green[900],
          secondaryContainer: Colors.blue[100],
          onSecondaryContainer: Colors.blue[900],
        ),
        textTheme: GoogleFonts.latoTextTheme(Theme.of(context).textTheme),

        appBarTheme: AppBarTheme(
          backgroundColor: AppTheme.primaryColor,
          foregroundColor: Colors.white,
          elevation: 2.0,
          centerTitle: true,
          titleTextStyle: GoogleFonts.lato(
            fontSize: 20,
            fontWeight: FontWeight.w600,
            color: Colors.white,
          ),
        ),

        scaffoldBackgroundColor: AppTheme.backgroundGradient.colors.first,
      ),
      home: MainMenuScreen(),
      debugShowCheckedModeBanner: false,
    );
  }
}
