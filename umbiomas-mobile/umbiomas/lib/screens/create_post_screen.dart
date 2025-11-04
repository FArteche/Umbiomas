import 'package:flutter/material.dart';
import 'dart:io'; // Para File (imagem)
import 'package:image_picker/image_picker.dart'; // Para selecionar imagem
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
  final _formKey = GlobalKey<FormState>(); // Chave para validar o formulário
  final ApiService apiService = ApiService();
  bool _isLoading = false; // Controla o indicador de progresso

  // Controladores para os campos de texto
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Criar Novo Post')),
      body: SingleChildScrollView(
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
              SizedBox(height: 10),
              TextFormField(
                controller: _nomeController,
                decoration: InputDecoration(labelText: 'Seu Nome*'),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              SizedBox(height: 10),
              TextFormField(
                controller: _emailController,
                decoration: InputDecoration(labelText: 'Seu Email*'),
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
              SizedBox(height: 10),
              TextFormField(
                controller: _telefoneController,
                decoration: InputDecoration(
                  labelText: 'Seu Telefone*',
                  filled: true,
                  fillColor: Colors.green[100],
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8.0),
                    borderSide: BorderSide.none,
                  ),
                ),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              SizedBox(height: 10),
              TextFormField(
                controller: _ocupacaoController,
                decoration: InputDecoration(
                  labelText: 'Sua Ocupação*',
                  filled: true,
                  fillColor: Colors.green[100],
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8.0),
                    borderSide: BorderSide.none,
                  ),
                ),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              SizedBox(height: 10),
              TextFormField(
                controller: _instituicaoController,
                decoration: InputDecoration(
                  labelText: 'Instituição que pertence*',
                  alignLabelWithHint: true,
                  filled: true,
                  fillColor: Colors.green[100],
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8.0),
                    borderSide: BorderSide.none,
                  ),
                ),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              SizedBox(height: 24),
              Text(
                'Detalhes do Post',
                style: Theme.of(context).textTheme.titleLarge,
              ),
              SizedBox(height: 10),
              TextFormField(
                controller: _tituloController,
                decoration: InputDecoration(labelText: 'Título do Post*'),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              TextFormField(
                controller: _textoController,
                decoration: InputDecoration(labelText: 'Texto do Post*'),
                maxLines: 5, 
                validator: (value) =>
                    value == null || value.isEmpty ? 'Campo obrigatório' : null,
              ),
              SizedBox(height: 16),

              OutlinedButton.icon(
                onPressed: _pickImage,
                icon: Icon(Icons.image),
                label: Text(
                  _imageFile == null
                      ? 'Selecionar Imagem'
                      : 'Imagem Selecionada',
                ),
              ),
              if (_imageFile != null)
                Padding(
                  padding: const EdgeInsets.only(top: 8.0),
                  child: Image.file(
                    _imageFile!,
                    height: 100,
                  ),
                ),

              SizedBox(height: 24),

              ElevatedButton(
                onPressed: _isLoading
                    ? null
                    : _submitForm, 
                child: _isLoading
                    ? SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(
                          strokeWidth: 2,
                          color: Colors.white,
                        ),
                      )
                    : Text('Enviar Post'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
