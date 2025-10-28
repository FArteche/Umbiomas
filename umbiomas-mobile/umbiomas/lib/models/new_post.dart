class NewPost {
  final String titulo;
  final String texto;
  final int biomaId;

  NewPost({
    required this.titulo,
    required this.texto,
    required this.biomaId,
  });

  Map<String, dynamic> toJson() {
    return {
      'titulo': titulo,
      'texto': texto,
      'bioma_id': biomaId,
    };
  }
}