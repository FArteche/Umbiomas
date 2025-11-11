// lib/screens/app_main_screen.dart
import 'package:flutter/material.dart';
import 'biomas_screen.dart';
import 'posts_biomes_screen.dart';
import 'quiz_selection_screen.dart';
import 'create_suggestion_screen.dart';

class AppMainScreen extends StatefulWidget {
  final int startingIndex; 
  const AppMainScreen({Key? key, this.startingIndex = 0}) : super(key: key);

  @override
  _AppMainScreenState createState() => _AppMainScreenState();
}

class _AppMainScreenState extends State<AppMainScreen> {
  late int _selectedIndex; 

  static final List<Color> _sectionColors = [
    Colors.green[800]!, // 0: Biomas
    Colors.blue[800]!,   // 1: Posts
    Colors.purple[700]!, // 2: Quiz
    Colors.orange[700]!, // 3: Sugestões
  ];

  static final List<Color> _sectionUnselectedColors = [
    Colors.green[100]!.withOpacity(0.7),
    Colors.blue[100]!.withOpacity(0.7),
    Colors.purple[100]!.withOpacity(0.7),
    Colors.orange[100]!.withOpacity(0.7),
  ];
  // ------------------------------------------

  static final List<Widget> _mainScreens = <Widget>[
    BiomasScreen(),
    PostsBiomesScreen(),
    QuizSelectionScreen(),
    CreateSuggestionScreen(),
  ];

  @override
  void initState() {
    super.initState();
    _selectedIndex = widget.startingIndex; 
  }

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

        // --- ESTILO DINÂMICO ---
        backgroundColor: _sectionColors[_selectedIndex], 
        selectedItemColor: Colors.white,               
        unselectedItemColor: _sectionUnselectedColors[_selectedIndex], 
        
        selectedFontSize: 12.0,
        unselectedFontSize: 12.0,
        
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