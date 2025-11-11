// lib/screens/post_details_screen.dart
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
// Removido o import do StyledContentBox

import '../models/post.dart';

class PostDetailScreen extends StatelessWidget {
  final Post post;
  const PostDetailScreen({Key? key, required this.post}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final String formattedDate = DateFormat(
      'dd \'de\' MMMM \'de\' yyyy',
      'pt_BR',
    ).format(post.dataPublicacao);

    return Scaffold(
      appBar: AppBar(
        title: FittedBox(fit: BoxFit.scaleDown, child: Text(post.titulo)),
        backgroundColor: Colors.blue[800], // Cor tema
      ),
      // Adiciona o container com o gradiente de fundo
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightBlue[100]!, Colors.white], // Gradiente
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Container Estilizado para "Byline" (Autor/Data)
              Container(
                padding: const EdgeInsets.all(12.0),
                decoration: BoxDecoration(
                  color: Colors.lightBlue[100], // Cor tema
                  border: Border.all(
                    color: Colors.blue[900]!, // Cor tema
                    width: 1.5,
                  ),
                  borderRadius: BorderRadius.circular(5.0),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.3),
                      spreadRadius: 1,
                      blurRadius: 3,
                      offset: Offset(0, 2),
                    ),
                  ],
                ),
                child: Column(
                  children: [
                    Text(
                      'Por: ${post.postador?.nome ?? 'Autor Desconhecido'}',
                      textAlign: TextAlign.center,
                      style: Theme.of(context).textTheme.titleSmall?.copyWith(
                        color: Colors.black87,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    SizedBox(height: 4),
                    Text(
                      'Publicado em: $formattedDate',
                      textAlign: TextAlign.center,
                      style: Theme.of(context).textTheme.titleSmall?.copyWith(
                        color: Colors.black54,
                        fontStyle: FontStyle.italic,
                      ),
                    ),
                  ],
                ),
              ),

              SizedBox(height: 24),

              // Container da Imagem (se houver)
              if (post.midiaUrl != null)
                Container(
                  height: 250,
                  width: double.infinity,
                  clipBehavior: Clip.antiAlias,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(
                      12.0,
                    ), // Borda mais arredondada
                    color: Colors.blue[900], // Cor tema de fundo
                  ),
                  child: Image.network(
                    post.midiaUrl!,
                    fit: BoxFit.cover,
                    // ... (loadingBuilder e errorBuilder mantidos) ...
                  ),
                ),

              SizedBox(height: 24),

              // Container Estilizado para o Texto do Post
              Container(
                padding: const EdgeInsets.all(16.0),
                decoration: BoxDecoration(
                  color: Colors.lightBlue[100], // Cor tema
                  border: Border.all(
                    color: Colors.blue[900]!, // Cor tema
                    width: 1.5,
                  ),
                  borderRadius: BorderRadius.circular(5.0),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.3),
                      spreadRadius: 1,
                      blurRadius: 3,
                      offset: Offset(0, 2),
                    ),
                  ],
                ),
                child: Text(
                  post.texto,
                  textAlign: TextAlign.justify,
                  style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                    fontSize: 16,
                    height: 1.5,
                    color: Colors.black87,
                  ),
                ),
              ),
              SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }
}
