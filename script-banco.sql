--criando o usuario e senha do banco de dados
CREATE ROLE banco LOGIN
  ENCRYPTED PASSWORD 'md5cd2f6e7a719acd24be2000076f9da2c2'
  SUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;
--criando o banco de dados
CREATE DATABASE imagens
  WITH OWNER = banco
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'pt_BR.UTF-8'
       LC_CTYPE = 'pt_BR.UTF-8'
       CONNECTION LIMIT = -1;

--criando a tabela de arquivos
CREATE TABLE arquivos (
 	id SERIAL PRIMARY KEY ,
  	nome VARCHAR(250),
  	datacadastro TIMESTAMP ,
  	arquivo VARCHAR(255)
);