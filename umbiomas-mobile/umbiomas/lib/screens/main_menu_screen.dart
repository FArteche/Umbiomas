// lib/screens/main_menu_screen.dart
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart'; // Usaremos Google Fonts para o título
import 'package:umbiomas/widgets/nav_button.dart';
import 'biomas_screen.dart';
import 'posts_biomes_screen.dart';
import 'create_suggestion_screen.dart';
import 'quiz_selection_screen.dart';
import '../navigation/fade_page_route.dart'; // Usando nossa animação de fade

class MainMenuScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightGreen[500]!, Colors.lightGreen[50]!],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [
              0.0,
              0.7,
            ], 
          ),
        ),
        child: SafeArea(
          bottom: false, // Permite que o conteúdo vá até a base
          child: SingleChildScrollView(
            // Permite rolar em telas menores
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: <Widget>[
                SizedBox(height: 50),

                // O Logo
                Image.asset('assets/images/logo_tr.png', height: 60),

                SizedBox(height: 2), // Espaço entre o logo e o título
                // Título "UmBiomas"
                Text(
                  'UmBiomas',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.lato(
                    fontSize: 48,
                    fontWeight: FontWeight.w900, 
                    color: Color(0xFF333333),
                  ),
                ),
                // Slogan
                Text(
                  'Explore, aprenda e colabore.',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.lato(
                    fontSize: 18,
                    fontWeight: FontWeight.w400,
                    color: Colors.grey[700],
                  ),
                ),

                SizedBox(height: 40), 

                Padding(
                  padding: const EdgeInsets.all(10.0),
                  child: Column(
                    children: [
                      NavButton(
                        icon: Icons.public_rounded,
                        title: 'Explorar Biomas',
                        subtitle: 'Navegue pelos ecossistemas',
                        color: const Color.fromRGBO(46, 125, 50, 1), 
                        iconOnRight: false,
                        onPressed: () {
                          Navigator.push(
                            context,
                            FadePageRoute(child: BiomasScreen()),
                          );
                        },
                      ),
                      SizedBox(height: 16),
                      NavButton(
                        icon: Icons.chat_bubble_outline_rounded,
                        title: 'Posts',
                        subtitle: 'Veja as publicações',
                        color: Color(0xFF3498db), 
                        onPressed: () {
                          Navigator.push(
                            context,
                            FadePageRoute(child: PostsBiomesScreen()),
                          );
                        },
                      ),
                      SizedBox(height: 16), 
                      NavButton(
                        icon: Icons.quiz_outlined,
                        title: 'Quiz',
                        subtitle: 'Teste seus conhecimentos',
                        color: Color(0xFF9b59b6), 
                        onPressed: () {
                          Navigator.push(
                            context,
                            FadePageRoute(child: QuizSelectionScreen()),
                          );
                        },
                      ),
                      SizedBox(height: 16),
                      NavButton(
                        icon: Icons.lightbulb_outline_rounded,
                        title: 'Enviar Sugestões',
                        subtitle: 'Contribua com o app',
                        color: Color(0xFFf39c12), 
                        onPressed: () {
                          Navigator.push(
                            context,
                            FadePageRoute(child: CreateSuggestionScreen()),
                          );
                        },
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
