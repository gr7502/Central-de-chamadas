<div class="page-home">
    <h2>Bem-vindo a Gees!</h2>
    <p>Escolha uma opção no menu lateral.</p>
</div>

<style>
    .page-home {
        min-height: 100vh;
        margin: -2rem;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 0;
        position: relative;
        overflow: hidden;
    }

    .page-home::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        opacity: 0.06;
        pointer-events: none;
    }

    .page-home h2,
    .page-home p {
        position: relative;
        z-index: 1;
    }

    .page-home h2 {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pageHomeFadeIn 0.5s ease-in-out;
    }

    .page-home p {
        font-size: 1.2rem;
        color: #6b7280;
        animation: pageHomeFadeIn 0.7s ease-in-out;
    }

    @keyframes pageHomeFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .page-home {
            margin: -1.5rem;
            padding: 1.5rem;
        }

        .page-home h2 {
            font-size: 2rem;
        }

        .page-home p {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .page-home {
            margin: -1rem;
            padding: 1rem;
        }

        .page-home h2 {
            font-size: 1.6rem;
        }

        .page-home p {
            font-size: 0.95rem;
        }
    }
</style>
