// lib/screens/create_post_screen.dart
import 'package:flutter/material.dart';
import 'dart:io';
import 'package:image_picker/image_picker.dart';
import '../services/api_service.dart';
import '../models/info_postador.dart';
import '../models/new_post.dart';

class CreatePostScreen extends StatefulWidget {
  final int biomaId;
  CreatePostScreen({required this.biomaId});

  @override
  _CreatePostScreenState createState() => _CreatePostScreenState();
}

class _CreatePostScreenState extends State<CreatePostScreen> {
  // ... (Toda a lógica de controladores e funções é mantida) ...
  final _formKey = GlobalKey<FormState>();
  final ApiService apiService = ApiService();
  bool _isLoading = false;
  final _nomeController = TextEditingController();
  final _emailController = TextEditingController();
  final _telefoneController = TextEditingController();
  final _instituicaoController = TextEditingController();
  final _ocupacaoController = TextEditingController();
  final _tituloController = TextEditingController();
  final _textoController = TextEditingController();
  File? _imageFile;

  @override
  void dispose() {
    _nomeController.dispose();
    _emailController.dispose();
    _telefoneController.dispose();
    _instituicaoController.dispose();
    _ocupacaoController.dispose();
    _textoController.dispose();
    _tituloController.dispose();
    super.dispose();
  }

  Future<void> _pickImage() async {
    final ImagePicker picker = ImagePicker();
    final XFile? pickedFile = await picker.pickImage(
      source: ImageSource.gallery,
    );

    setState(() {
      if (pickedFile != null) {
        _imageFile = File(pickedFile.path);
      }
    });
  }

  Future<void> _submitForm() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() => _isLoading = true);

    final postador = InfoPostador(
      nome: _nomeController.text,
      email: _emailController.text,
      telefone: _telefoneController.text,
      instituicao: _instituicaoController.text,
      ocupacao: _ocupacaoController.text,
    );

    final newPost = NewPost(
      titulo: _tituloController.text,
      texto: _textoController.text,
      biomaId: widget.biomaId,
    );

    try {
      await apiService.createPost(
        postador: postador,
        post: newPost,
        midia: _imageFile,
      );

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Post enviado para moderação!'),
          backgroundColor: Colors.green,
        ),
      );
      Navigator.of(context).pop(true);
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erro ao enviar post: $e'),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }

  // Helper para o estilo dos TextFormFields
  InputDecoration _inputDecoration(String label) {
    return InputDecoration(
      labelText: label,
      alignLabelWithHint: true,
      filled: true,
      fillColor: Colors.lightBlue[200]!.withOpacity(0.6), // Cor tema
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide.none, // Sem borda
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide(
          color: Colors.blue[800]!,
          width: 2,
        ), // Borda azul ao focar
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Criar Novo Post'),
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
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                Text(
                  'Suas Informações',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _nomeController,
                  decoration: _inputDecoration('Seu Nome*'),
                  validator: (value) => value == null || value.isEmpty
                      ? 'Campo obrigatório'
                      : null,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _emailController,
                  decoration: _inputDecoration('Seu Email*'),
                  keyboardType: TextInputType.emailAddress,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Campo obrigatório';
                    }
                    final emailRegex = RegExp(
                      r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~-]+@[a-zA-Z0-9]+\.[a-zA-Z]+",
                    );
                    if (!emailRegex.hasMatch(value)) {
                      return 'Por favor, insira um email válido';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _telefoneController,
                  decoration: _inputDecoration('Seu Telefone'),
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _ocupacaoController,
                  decoration: _inputDecoration('Sua Ocupação'),
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _instituicaoController,
                  decoration: _inputDecoration('Instituição que pertence'),
                ),
                SizedBox(height: 24),
                Text(
                  'Detalhes do Post',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _tituloController,
                  decoration: _inputDecoration(
                    'Título do Post*',
                  ), // Estilo aplicado
                  validator: (value) => value == null || value.isEmpty
                      ? 'Campo obrigatório'
                      : null,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _textoController,
                  decoration: _inputDecoration(
                    'Texto do Post*',
                  ), // Estilo aplicado
                  maxLines: 5,
                  validator: (value) => value == null || value.isEmpty
                      ? 'Campo obrigatório'
                      : null,
                ),
                SizedBox(height: 16),

                // Botão de Imagem Estilizado
                OutlinedButton.icon(
                  onPressed: _pickImage,
                  icon: Icon(Icons.image),
                  label: Text(
                    _imageFile == null
                        ? 'Selecionar Imagem'
                        : 'Imagem Selecionada',
                  ),
                  style: OutlinedButton.styleFrom(
                    foregroundColor: Colors.blue[800],
                    side: BorderSide(color: Colors.blue[800]!),
                    padding: EdgeInsets.symmetric(vertical: 12),
                  ),
                ),
                if (_imageFile != null)
                  Padding(
                    padding: const EdgeInsets.only(top: 10.0),
                    child: ClipRRect(
                      // Adiciona bordas arredondadas ao preview
                      borderRadius: BorderRadius.circular(12.0),
                      child: Image.file(
                        _imageFile!,
                        height: 150,
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),

                SizedBox(height: 24),

                // Botão de Envio Estilizado
                ElevatedButton(
                  onPressed: _isLoading ? null : _submitForm,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.blue[800], // Cor tema
                    foregroundColor: Colors.white,
                    padding: EdgeInsets.symmetric(vertical: 16),
                  ),
                  child: _isLoading
                      ? SizedBox(/* ... (loading indicator mantido) ... */)
                      : Text('Enviar Post', style: TextStyle(fontSize: 16)),
                ),
                SizedBox(height: 50),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
