import 'package:flutter/material.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/post_details_screen.dart';
import '../services/api_service.dart';
import '../models/post.dart'; // Model Post que criamos para exibição
import 'create_post_screen.dart'; // Tela de criação (vamos criar)

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
      appBar: AppBar(title: Text('Posts - ${widget.biomaNome}')),
      body: RefreshIndicator(
        // Permite puxar para atualizar
        onRefresh: () async => _fetchPosts(),
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
                itemCount: posts.length,
                itemBuilder: (context, index) {
                  final post = posts[index];
                  return Card(
                    color: Colors.lightGreen[100],
                    child: ListTile(
                      title: Text(
                        post.titulo,
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ),
                      subtitle: Text(
                        post.texto,
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      trailing: Text(
                        post.dataPublicacao.toIso8601String().substring(
                          0,
                          10,
                        ),
                        style: TextStyle(fontSize: 12, color: Colors.grey),
                      ),
                      onTap: () {
                        Navigator.push(
                          context,
                          FadePageRoute(
                            child: PostDetailScreen(
                              post: post,
                            ), 
                          ),
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
      // Botão Flutuante para Criar Novo Post
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () async {
          final result = await Navigator.push<bool>(
            context,
            MaterialPageRoute(
              builder: (context) => CreatePostScreen(biomaId: widget.biomaId),
            ),
          );
          if (result == true) {
            _fetchPosts();
          }
        },
        icon: Icon(Icons.add),
        label: Text('Novo Post'),
      ),
    );
  }
}
