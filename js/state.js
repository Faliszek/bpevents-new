export const stateCreator = () => {
  return {
    header: {
      links: []
    },
    contact: {
      desc: "",
      img: {}
    },

    gallery: {
      text: "",
      equipmentTitle: "",
      equipment: [],
      photosTitle: "",
      photos: [],
      videosTitle: "",
      videos: []
    },

    home: {
      text: "",
      slides: [],
      offers: [],
      content: []
    },

    recommend: {
      text: "",
      recommendations: []
    },

    references: {
      text: "",
      refs: [],
      facebookLink: ""
    },
    cmsData: "",
    footer: {
      widget: {},
      menu: {
        title: "",
        links: []
      }
    }
  };
};
