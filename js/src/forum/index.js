import app from 'flarum/forum/app';

import downloadButtonInteraction from './downloadButtonInteraction';

app.initializers.add('gbcl-fof-upload-qcloud', () => {
  downloadButtonInteraction();
});
