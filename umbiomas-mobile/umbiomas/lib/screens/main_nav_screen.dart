import 'package:flutter/material.dart';
import 'package:umbiomas/screens/biomas_screen.dart';
import 'package:umbiomas/screens/posts_biomes_screen.dart';
import 'package:umbiomas/screens/quiz_selection_screen.dart';
import 'package:umbiomas/screens/create_suggestion_screen.dart';

class MainNavScreen extends StatefulWidget {
  const MainNavScreen({Key? key}) : super(key: key);

  @override
  _MainNavScreenState createState() => _MainNavScreenState();
}

class _MainNavScreenState extends State<MainNavScreen> {
  int _selectedIndex = 0;

  static final List<Widget> _mainScreens = <Widget>[
    BiomasScreen(),
    PostsBiomesScreen(),
    QuizSelectionScreen(),
    CreateSuggestionScreen(),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: IndexedStack(
        index: _selectedIndex,
        children: _mainScreens,
      ),

      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,

        type: BottomNavigationBarType.fixed,
        
        backgroundColor: Colors.green[800],
        
        selectedItemColor: Colors.white,
        
        unselectedItemColor: Colors.green[100]!.withOpacity(0.7),
        
        selectedFontSize: 12.0,
        unselectedFontSize: 12.0,

        // --- ITENS DA BARRA ---
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.public),
            label: 'Biomas',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.article),
            label: 'Posts',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.quiz),
            label: 'Quiz',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.lightbulb),
            label: 'Sugestões',
          ),
        ],
      ),
    );
  }
}