   <!-- Afficher les messages d'erreur ou de succès -->
                        <?php if (!empty($error_message)) : ?>
                            <div type="button" class="error-message btn btn-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <?php if (!empty($success_message)) : ?>
                            <div type="button" class="success-message btn btn-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>


                        <div class="head">
                            <a href="create_user.php">
                                <h3>Supprimer le service</h3>
                            </a>
                        </div>  