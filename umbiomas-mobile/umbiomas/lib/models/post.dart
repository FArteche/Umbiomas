class Postador {
  final String nome;
  final String? instituicao;

  Postador({required this.nome, this.instituicao});

  factory Postador.fromJson(Map<String, dynamic> json) {
    return Postador(nome: json['nome'], instituicao: json['instituicao']);
  }
}

class Post {
  final int id;
  final String titulo;
  final String texto;
  final String? midiaUrl;
  final DateTime dataPublicacao;
  final Postador? postador;

  Post({
    required this.id,
    required this.titulo,
    required this.texto,
    this.midiaUrl,
    required this.dataPublicacao,
    this.postador,
  });

  factory Post.fromJson(Map<String, dynamic> json) {
    return Post(
      id: json['id'] as int? ?? 0,
      titulo: json['titulo'] as String? ?? 'Titulo indisponível',
      texto: json['texto'] as String? ?? 'Texto indisponível',
      midiaUrl: json['midia_url'] as String?,
      dataPublicacao: DateTime.parse(json['data_publicacao']),
      postador: json['postador'] != null
          ? Postador.fromJson(json['postador'])
          : null,
    );
  }
}
