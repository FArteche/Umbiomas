import 'package:flutter/material.dart';
import 'package:intl/date_symbol_data_local.dart';
import 'package:umbiomas/screens/main_menu_screen.dart';
import 'package:google_fonts/google_fonts.dart';

void main() async {
  // Transforme o main em async
  WidgetsFlutterBinding.ensureInitialized();
  await initializeDateFormatting('pt_BR', null);
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final Color seedColor = Colors.green[800]!;

    return MaterialApp(
      title: 'UmBiomas App',
      theme: ThemeData(
        useMaterial3: true,

        colorScheme: ColorScheme.fromSeed(
          seedColor: seedColor,
          brightness: Brightness.light,
        ),

        textTheme: GoogleFonts.merriweatherTextTheme(
          Theme.of(context).textTheme,
        ),

        appBarTheme: AppBarTheme(
          backgroundColor: seedColor,
          foregroundColor: Colors.white,
          elevation: 4.0,
          centerTitle: true,
          titleTextStyle: GoogleFonts.merriweather(
            fontSize: 25,
            fontWeight: FontWeight.w600,
            color: Colors.white,
          ),
        ),

        cardTheme: CardThemeData(
          elevation: 2.0,
          margin: EdgeInsets.symmetric(horizontal: 10, vertical: 6),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12.0),
          ),
        ),

        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: seedColor,
            foregroundColor: Colors.white,
            padding: EdgeInsets.symmetric(horizontal: 20, vertical: 12),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(8.0),
            ),
          ),
        ),

        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: MainMenuScreen(), 
      debugShowCheckedModeBanner: false,
    );
  }
}
