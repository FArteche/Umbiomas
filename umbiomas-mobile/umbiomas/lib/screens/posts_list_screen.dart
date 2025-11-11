// lib/screens/posts_list_screen.dart
import 'package:flutter/material.dart';
import 'package:intl/intl.dart'; // Import para formatar data
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/post_details_screen.dart';
import '../services/api_service.dart';
import '../models/post.dart';
import 'create_post_screen.dart';

class PostsListScreen extends StatefulWidget {
  final int biomaId;
  final String biomaNome;

  PostsListScreen({required this.biomaId, required this.biomaNome});

  @override
  _PostsListScreenState createState() => _PostsListScreenState();
}

class _PostsListScreenState extends State<PostsListScreen> {
  final ApiService apiService = ApiService();
  late Future<List<Post>> _postsFuture;

  @override
  void initState() {
    super.initState();
    _fetchPosts();
  }

  void _fetchPosts() async {
    setState(() {
      _postsFuture = apiService.fetchPostsByBioma(widget.biomaId);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Posts - ${widget.biomaNome}'),
        backgroundColor: Colors.blue[800], // Cor tema da seção
      ),
      // Adiciona o container com o gradiente de fundo
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightBlue[100]!, Colors.white], // Gradiente
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: RefreshIndicator(
          onRefresh: () async => _fetchPosts(),
          color: Colors.blue[800], // Cor do refresh
          child: FutureBuilder<List<Post>>(
            future: _postsFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return Center(child: CircularProgressIndicator());
              } else if (snapshot.hasError) {
                return Center(child: Text('Erro: ${snapshot.error}'));
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return Center(
                  child: Text('Nenhum post encontrado para este bioma.'),
                );
              } else {
                List<Post> posts = snapshot.data!;
                return ListView.builder(
                  // Adiciona padding na lista
                  padding: EdgeInsets.all(10.0),
                  itemCount: posts.length,
                  itemBuilder: (context, index) {
                    final post = posts[index];
                    return Card(
                      // Card branco e limpo
                      color: Colors.white,
                      elevation: 2.0,
                      margin: EdgeInsets.symmetric(vertical: 6.0),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12.0),
                      ),
                      child: ListTile(
                        // Adiciona padding interno
                        contentPadding: EdgeInsets.symmetric(
                          horizontal: 16.0,
                          vertical: 10.0,
                        ),
                        // Adiciona imagem (leading)
                        leading: ClipRRect(
                          borderRadius: BorderRadius.circular(8.0),
                          child: Container(
                            width: 60,
                            height: 60,
                            color: Colors.grey[200],
                            child: post.midiaUrl != null
                                ? Image.network(
                                    post.midiaUrl!,
                                    fit: BoxFit.cover,
                                    errorBuilder: (c, e, s) => Icon(
                                      Icons.broken_image,
                                      color: Colors.grey,
                                    ),
                                  )
                                : Icon(
                                    Icons.article_outlined,
                                    color: Colors.grey,
                                  ),
                          ),
                        ),
                        title: Text(
                          post.titulo,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                          ),
                        ),
                        subtitle: Text(
                          post.texto,
                          maxLines: 2,
                          overflow: TextOverflow.ellipsis,
                        ),
                        // Mostra a data formatada
                        trailing: Text(
                          DateFormat(
                            'dd/MM/yy',
                            'pt_BR',
                          ).format(post.dataPublicacao),
                          style: TextStyle(
                            fontSize: 12,
                            color: Colors.grey[600],
                          ),
                        ),
                        onTap: () {
                          Navigator.push(
                            context,
                            FadePageRoute(child: PostDetailScreen(post: post)),
                          );
                        },
                      ),
                    );
                  },
                );
              }
            },
          ),
        ),
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () async {
          final result = await Navigator.push<bool>(
            context,
            FadePageRoute(child: CreatePostScreen(biomaId: widget.biomaId)),
          );
          if (result == true) {
            _fetchPosts();
          }
        },
        icon: Icon(Icons.add, color: Colors.white),
        label: Text('Novo Post', style: TextStyle(color: Colors.white)),
        backgroundColor: Colors.blue[800], // Cor tema da seção
      ),
    );
  }
}
