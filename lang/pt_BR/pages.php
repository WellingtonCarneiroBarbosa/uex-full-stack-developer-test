<?php

return [
    'auth' => [
        'login' => [
            'title'           => 'Entrar',
            'remember-me'     => 'Manter conectado',
            'forgot-password' => 'Esqueceu sua senha?',
            'login'           => 'Entrar',
            'have-no-account' => 'Ainda não tem uma conta?',
            'register-now'    => 'Cadastre-se agora!',
        ],

        'register' => [
            'title'              => 'Criar Conta',
            'create-account'     => 'Criar Conta',
            'already-registered' => 'Já possui uma conta?',
            'login-now'          => 'Faça login agora!',
        ],

        'forgot-password' => [
            'title'      => 'Esqueci Minha Senha',
            'disclaimer' => 'Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha para que você possa escolher uma nova.',
            'send'       => 'Enviar link de redefinição',
        ],

        'reset-password' => [
            'title' => 'Resetar Senha',
        ],
    ],

    'profile' => [
        'title' => 'Meu Perfil',

        'personal-information' => [
            'title'       => 'Informações do Perfil',
            'description' => 'Atualize as informações do perfil e o endereço de e-mail da sua conta',

            'form' => [
                'new-photo'    => 'Selecione Uma Nova Foto',
                'remove-photo' => 'Remover Foto',

                'unverified'        => 'Seu endereço de e-mail não está verificado.',
                'verify-now'        => 'Clique aqui para reenviar o e-mail de verificação.',
                'verification-sent' => 'Um novo link de verificação foi enviado para o seu endereço de e-mail.',
            ],
        ],

        'update-password' => [
            'title'       => 'Atualizar Senha',
            'description' => 'Certifique-se de que sua conta está usando uma senha longa e aleatória para permanecer segura',
        ],

        'two-f-auth' => [
            'title'       => 'Autenticação de Dois Fatores',
            'description' => 'Adicione segurança adicional à sua conta usando autenticação de dois fatores',

            'not-enabled-title'      => 'Você não ativou a autenticação de dois fatores',
            'not-enabled-disclaimer' => 'Quando a autenticação de dois fatores está ativada, você será solicitado a fornecer um token seguro e aleatório durante a autenticação. Você pode obter este token no aplicativo Google Authenticator do seu telefone',

            'enabled-title'      => 'Você ativou a autenticação de dois fatores',
            'enabled-disclaimer' => 'A autenticação de dois fatores está agora ativada. Escaneie o código QR a seguir usando o aplicativo autenticador do seu telefone ou insira a chave de configuração',

            'finish-title'      => 'Concluir a ativação da autenticação de dois fatores',
            'finish-disclaimer' => 'Para concluir a ativação da autenticação de dois fatores, escaneie o código QR a seguir usando o aplicativo autenticador do seu telefone ou insira a chave de configuração e forneça o código OTP gerado',

            'setup-key' => 'Chave de configuração',

            'save-keys' => 'Armazene esses códigos de recuperação em um gerenciador de senhas seguro. Eles podem ser usados para recuperar o acesso à sua conta se o seu dispositivo de autenticação de dois fatores for perdido',

            'regenerate'           => 'Regenerar Códigos de Recuperação',
            'show-recovery-codes'  => 'Mostrar Códigos de Recuperação',
        ],

        'sessions' => [
            'title'       => 'Sessões de Navegador',
            'description' => 'Gerencie e encerre suas sessões ativas em outros navegadores e dispositivos',

            'disclaimer'    => 'Se necessário, você pode encerrar todas as suas outras sessões de navegador em todos os seus dispositivos. Algumas de suas sessões recentes estão listadas abaixo; no entanto, esta lista pode não ser exaustiva. Se você sentir que sua conta foi comprometida, também deve atualizar sua senha',
            'this-device'   => 'Este dispositivo',
            'last-activity' => 'Última atividade',
            'logout'        => 'Encerrar outras sessões de navegador',

            'modal' => [
                'description' => 'Por favor, insira sua senha para confirmar que deseja encerrar suas outras sessões de navegador em todos os seus dispositivos.',
            ],
        ],

        'delete-account' => [
            'title'       => 'Deletar Conta',
            'description' => 'Excluir permanentemente sua conta',
            'disclaimer'  => 'Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente excluídos. Antes de deletar sua conta, por favor, faça o download de qualquer dado ou informação que você deseja reter',

            'are-you-sure' => "Tem certeza de que deseja deletar sua conta? Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente excluídos. Por favor, insira sua senha para confirmar que deseja deletar permanentemente sua conta",
        ],

    ],

    'contacts' => [
        'title'       => 'Contatos',
        'description' => 'Gerencie sua lista de contatos',

        'no-contacts' => "Você ainda não possui contatos. Adicione um para começar",

        'any-contacts-found' => "Nenhum contato encontrado",

        'confirm-deleting' => [
            'title'       => 'Você tem certeza?',
            'description' => 'O contato :name será permanentemente excluído!',
        ],

        'form' => [
            'common' => [
                'contact-information' => 'Informações de Contato',
                'address'             => 'Endereço',
            ],

            'create' => [
                'title'       => 'Adicionar Contato',
                'description' => 'Insira as informações do contato para cadastrá-lo',
            ],

            'edit' => [
                'title'       => 'Editar Contato',
                'description' => 'Atualize as informações do contato',
            ],
        ],
    ],

];
