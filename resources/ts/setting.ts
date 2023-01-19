export interface ISetting {
  showTagsView: boolean;
  tagsViewNum: number;
}

const setting: ISetting = {
  /**
   * @type {boolean} true | false
   * @description Whether show TagsView
   */
  showTagsView: true,
  /**
   * @type {number}
   * @description TagsView show number
   */
  tagsViewNum: 3,
};

export default setting;
